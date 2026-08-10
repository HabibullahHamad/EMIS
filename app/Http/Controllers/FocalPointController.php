<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntity;
use App\Models\FocalPoint;
use App\Models\FocalPointCard;
use App\Models\FocalPointIntroduction;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Throwable;

class FocalPointController extends Controller
{
    /**
     * Display the focal-point list.
     */
    public function index(Request $request): View
    {
        $validated = Validator::make($request->query(), [
            'search' => ['nullable', 'string', 'max:150'],
            'budget_entity_id' => [
                'nullable',
                'integer',
                Rule::exists('budget_entities', 'id')->whereNull('deleted_at'),
            ],
            'status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'under_review',
                    'active',
                    'suspended',
                    'replaced',
                    'expired',
                    'rejected',
                    'inactive',
                ]),
            ],
        ])->validate();

        $query = FocalPoint::query()
            ->with([
                'budgetEntity',
                'introduction',
                'cards' => fn ($cards) => $cards->latest('id'),
            ])
            ->latest('id');

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);

            $query->where(function (EloquentBuilder $builder) use ($search): void {
                $builder
                    ->where('focal_point_code', 'like', "%{$search}%")
                    ->orWhere('full_name_en', 'like', "%{$search}%")
                    ->orWhere('full_name_ps', 'like', "%{$search}%")
                    ->orWhere('full_name_fa', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('employee_number', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($validated['budget_entity_id'])) {
            $query->where(
                'budget_entity_id',
                (int) $validated['budget_entity_id']
            );
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $focalPoints = $query
            ->paginate(20)
            ->withQueryString();

        $budgetEntities = BudgetEntity::query()
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        return view('focal-points.index', compact(
            'focalPoints',
            'budgetEntities'
        ));
    }

    /**
     * Open the single registration and card-management page.
     */
    public function registration(?FocalPoint $focalPoint = null): View
    {
        $budgetEntities = BudgetEntity::query()
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        $introductions = FocalPointIntroduction::query()
            ->with('budgetEntity')
            ->whereIn('status', [
                'received',
                'under_review',
                'approved',
                'completed',
            ])
            ->latest('id')
            ->get();

        if ($focalPoint?->exists) {
            $focalPoint->load([
                'budgetEntity',
                'introduction',
                'approver',
                'cards' => fn ($cards) => $cards->latest('id'),
            ]);
        }

        return view('focal-points.registration', compact(
            'focalPoint',
            'budgetEntities',
            'introductions'
        ));
    }

    /**
     * Resource compatibility: open the unified registration page.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('focal-points.registration');
    }

    /**
     * Store a newly registered focal point.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFocalPoint($request);

        $this->ensureIntroductionBelongsToEntity(
            (int) $validated['introduction_id'],
            (int) $validated['budget_entity_id']
        );

        $photoPath = null;
        $signaturePath = null;

        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')
                    ->store('focal-points/photos', 'public');
            }

            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')
                    ->store('focal-points/signatures', 'public');
            }

            $focalPoint = DB::transaction(function () use (
                $validated,
                $photoPath,
                $signaturePath
            ): FocalPoint {
                $temporaryCode = 'TMP-' . Str::uuid();

                $focalPoint = FocalPoint::create([
                    ...$validated,
                    'focal_point_code' => $validated['focal_point_code']
                        ?: $temporaryCode,
                    'photo_path' => $photoPath,
                    'signature_path' => $signaturePath,
                    'created_by' => auth()->id(),
                    'approved_by' => null,
                    'approved_at' => null,
                ]);

                if (empty($validated['focal_point_code'])) {
                    $focalPoint->forceFill([
                        'focal_point_code' => $this->makeFocalPointCode(
                            $focalPoint
                        ),
                    ])->save();
                }

                $this->writeAudit(
                    'focal_point_created',
                    $focalPoint,
                    null,
                    $focalPoint->fresh()->toArray()
                );

                return $focalPoint->fresh();
            });

            return redirect()
                ->route('focal-points.registration', $focalPoint)
                ->with(
                    'success',
                    __('messages.focal_point_created')
                );
        } catch (ValidationException $exception) {
            $this->deletePublicFile($photoPath);
            $this->deletePublicFile($signaturePath);

            throw $exception;
        } catch (Throwable $exception) {
            $this->deletePublicFile($photoPath);
            $this->deletePublicFile($signaturePath);

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    __('messages.focal_point_create_failed')
                );
        }
    }

    /**
     * Resource compatibility: open the unified page for a focal point.
     */
    public function show(FocalPoint $focalPoint): RedirectResponse
    {
        return redirect()->route(
            'focal-points.registration',
            $focalPoint
        );
    }

    /**
     * Resource compatibility: open the unified page for editing.
     */
    public function edit(FocalPoint $focalPoint): RedirectResponse
    {
        return redirect()->route(
            'focal-points.registration',
            $focalPoint
        );
    }

    /**
     * Update focal-point registration information.
     */
    public function update(
        Request $request,
        FocalPoint $focalPoint
    ): RedirectResponse {
        $validated = $this->validateFocalPoint(
            $request,
            $focalPoint
        );

        $this->ensureIntroductionBelongsToEntity(
            (int) $validated['introduction_id'],
            (int) $validated['budget_entity_id']
        );

        $oldValues = $focalPoint->toArray();
        $oldPhotoPath = $focalPoint->photo_path;
        $oldSignaturePath = $focalPoint->signature_path;

        $newPhotoPath = null;
        $newSignaturePath = null;

        try {
            if ($request->hasFile('photo')) {
                $newPhotoPath = $request->file('photo')
                    ->store('focal-points/photos', 'public');
            }

            if ($request->hasFile('signature')) {
                $newSignaturePath = $request->file('signature')
                    ->store('focal-points/signatures', 'public');
            }

            DB::transaction(function () use (
                $validated,
                $focalPoint,
                $newPhotoPath,
                $newSignaturePath,
                $oldValues
            ): void {
                $updateData = $validated;

                if ($newPhotoPath) {
                    $updateData['photo_path'] = $newPhotoPath;
                }

                if ($newSignaturePath) {
                    $updateData['signature_path'] = $newSignaturePath;
                }

                if ($validated['status'] !== 'active') {
                    $updateData['approved_by'] = null;
                    $updateData['approved_at'] = null;
                }

                $focalPoint->update($updateData);

                $this->writeAudit(
                    'focal_point_updated',
                    $focalPoint,
                    $oldValues,
                    $focalPoint->fresh()->toArray()
                );
            });

            if ($newPhotoPath) {
                $this->deletePublicFile($oldPhotoPath);
            }

            if ($newSignaturePath) {
                $this->deletePublicFile($oldSignaturePath);
            }

            return redirect()
                ->route('focal-points.registration', $focalPoint)
                ->with(
                    'success',
                    __('messages.focal_point_updated')
                );
        } catch (ValidationException $exception) {
            $this->deletePublicFile($newPhotoPath);
            $this->deletePublicFile($newSignaturePath);

            throw $exception;
        } catch (Throwable $exception) {
            $this->deletePublicFile($newPhotoPath);
            $this->deletePublicFile($newSignaturePath);

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    __('messages.focal_point_update_failed')
                );
        }
    }

    /**
     * Delete a focal point only when no card history exists.
     */
    public function destroy(
        FocalPoint $focalPoint
    ): RedirectResponse {
        $focalPoint->loadCount('cards');

        if ($focalPoint->cards_count > 0) {
            return back()->with(
                'error',
                __('messages.focal_point_has_card_history')
            );
        }

        $oldValues = $focalPoint->toArray();
        $photoPath = $focalPoint->photo_path;
        $signaturePath = $focalPoint->signature_path;

        try {
            DB::transaction(function () use (
                $focalPoint,
                $oldValues
            ): void {
                $this->writeAudit(
                    'focal_point_deleted',
                    $focalPoint,
                    $oldValues,
                    null
                );

                $focalPoint->delete();
            });

            $this->deletePublicFile($photoPath);
            $this->deletePublicFile($signaturePath);

            return redirect()
                ->route('focal-points.index')
                ->with(
                    'success',
                    __('messages.focal_point_deleted')
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                __('messages.focal_point_delete_failed')
            );
        }
    }

    /**
     * Approve a focal point and activate card-generation actions.
     */
    public function approve(
        FocalPoint $focalPoint
    ): RedirectResponse {
        if ($focalPoint->status === 'active') {
            return back()->with(
                'warning',
                __('messages.focal_point_already_approved')
            );
        }

        $oldValues = $focalPoint->toArray();

        try {
            DB::transaction(function () use (
                $focalPoint,
                $oldValues
            ): void {
                $focalPoint->update([
                    'status' => 'active',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                $this->writeAudit(
                    'focal_point_approved',
                    $focalPoint,
                    $oldValues,
                    $focalPoint->fresh()->toArray()
                );
            });

            return redirect()
                ->route('focal-points.registration', $focalPoint)
                ->with(
                    'success',
                    __('messages.focal_point_approved')
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                __('messages.focal_point_approval_failed')
            );
        }
    }

    /**
     * Suspend a focal point and revoke all currently valid cards.
     */
    public function suspend(
        FocalPoint $focalPoint
    ): RedirectResponse {
        if ($focalPoint->status === 'suspended') {
            return back()->with(
                'warning',
                __('messages.focal_point_already_suspended')
            );
        }

        $oldValues = $focalPoint->toArray();

        try {
            DB::transaction(function () use (
                $focalPoint,
                $oldValues
            ): void {
                $focalPoint->update([
                    'status' => 'suspended',
                    'approved_by' => null,
                    'approved_at' => null,
                ]);

                FocalPointCard::query()
                    ->where('focal_point_id', $focalPoint->id)
                    ->whereIn('card_status', [
                        'approved',
                        'printed',
                        'issued',
                    ])
                    ->update([
                        'card_status' => 'revoked',
                        'revoked_at' => now(),
                        'revoked_by' => auth()->id(),
                        'revocation_reason' => __(
                            'messages.card_auto_revoked_due_to_suspension'
                        ),
                        'updated_at' => now(),
                    ]);

                $this->writeAudit(
                    'focal_point_suspended',
                    $focalPoint,
                    $oldValues,
                    $focalPoint->fresh()->toArray()
                );
            });

            return redirect()
                ->route('focal-points.registration', $focalPoint)
                ->with(
                    'success',
                    __('messages.focal_point_suspended')
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                __('messages.focal_point_suspend_failed')
            );
        }
    }

    /**
     * Generate the first card, renew a card, or replace a card.
     */
    public function generateCard(
        Request $request,
        FocalPoint $focalPoint
    ): RedirectResponse {
        if ($focalPoint->status !== 'active') {
            return back()->with(
                'error',
                __('messages.focal_point_must_be_approved')
            );
        }

        $validated = $request->validate([
            'fiscal_year' => [
                'required',
                'string',
                'max:20',
            ],
            'issue_date' => [
                'required',
                'date',
            ],
            'expiry_date' => [
                'required',
                'date',
                'after_or_equal:issue_date',
            ],
            'generation_type' => [
                'nullable',
                Rule::in([
                    'renewal',
                    'replacement',
                ]),
            ],
            'reason' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $focalPoint->load('budgetEntity');

        $defaultGenerationReason = !empty(
            $validated['generation_type']
        )
            ? __(
                'messages.card_generation_type_' .
                $validated['generation_type']
            )
            : null;

        try {
            $card = DB::transaction(function () use (
                $validated,
                $focalPoint,
                $defaultGenerationReason
            ): FocalPointCard {
                $currentCard = FocalPointCard::query()
                    ->where(
                        'focal_point_id',
                        $focalPoint->id
                    )
                    ->latest('id')
                    ->lockForUpdate()
                    ->first();

                if ($currentCard) {
                    if (empty($validated['generation_type'])) {
                        throw ValidationException::withMessages([
                            'generation_type' => __(
                                'messages.select_renewal_or_replacement'
                            ),
                        ]);
                    }

                    if (
                        $currentCard->card_status !== 'revoked'
                        && $currentCard->card_status !== 'replaced'
                    ) {
                        $currentCard->update([
                            'card_status' => 'replaced',
                            'reprint_reason' =>
                                $validated['reason']
                                ?: $defaultGenerationReason,
                        ]);
                    }
                }

                $card = FocalPointCard::create([
                    'focal_point_id' => $focalPoint->id,
                    'card_number' => 'TMP-' . Str::uuid(),
                    'verification_uuid' => (string) Str::uuid(),
                    'fiscal_year' => $validated['fiscal_year'],
                    'issue_date' => $validated['issue_date'],
                    'expiry_date' => $validated['expiry_date'],
                    'card_status' => 'approved',

                    'printed_at' => null,
                    'printed_by' => null,

                    'issued_at' => null,
                    'issued_by' => null,
                    'received_by_name' => null,
                    'received_at' => null,
                    'receiver_signature_path' => null,

                    'pdf_path' => null,

                    'reprint_count' => $currentCard
                        ? ((int) $currentCard->reprint_count + 1)
                        : 0,

                    'reprint_reason' => $currentCard
                        ? (
                            $validated['reason']
                            ?: $defaultGenerationReason
                        )
                        : null,

                    'revoked_at' => null,
                    'revoked_by' => null,
                    'revocation_reason' => null,
                ]);

                $card->forceFill([
                    'card_number' => $this->makeCardNumber(
                        $card,
                        $focalPoint,
                        $validated['fiscal_year']
                    ),
                ])->save();

                $this->writeAudit(
                    $currentCard
                        ? 'focal_point_card_reissued'
                        : 'focal_point_card_generated',
                    $card,
                    null,
                    $card->fresh()->toArray()
                );

                return $card->fresh();
            });

            return redirect()
                ->route(
                    'focal-points.registration',
                    $focalPoint
                )
                ->with(
                    'success',
                    __(
                        'messages.card_generated',
                        [
                            'card_number' => $card->card_number,
                        ]
                    )
                );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    __('messages.card_generation_failed')
                );
        }
    }

    /**
     * Open the card from the card-history/View button.
     *
     * The current module uses the printable PDF as the card preview,
     * so this route redirects to printCard().
     */
    public function showCard(
        FocalPointCard $card
    ): RedirectResponse {
        return redirect()->route(
            'focal-point-cards.print',
            $card
        );
    }

    /**
     * Generate one standard portrait focal-point ID card.
     *
     * Physical card size: 53.98 mm × 85.60 mm.
     */
    public function printCard(
        FocalPointCard $card
    ): Response|RedirectResponse {
        if ($card->card_status === 'revoked') {
            abort(
                403,
                __('messages.revoked_card_cannot_be_printed')
            );
        }

        $card->load('focalPoint.budgetEntity');

        $focalPoint = $card->focalPoint;

        if (!$focalPoint) {
            abort(
                404,
                __('messages.card_focal_point_not_found')
            );
        }

        try {

            $verificationUrl = route(
                'focal-point-cards.verify',
                $card->verification_uuid
            );

            /*
             * endroid/qr-code 5.x API.
             */
            $qrResult = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($verificationUrl)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(
                    ErrorCorrectionLevel::High
                )
                ->size(320)
                ->margin(8)
                ->roundBlockSizeMode(
                    RoundBlockSizeMode::Margin
                )
                ->validateResult(false)
                ->build();

            $qr = base64_encode(
                $qrResult->getString()
            );

            /*
             * Convert a readable local image into a data URI for mPDF.
             */
            $fileToDataUri = static function (
                ?string $absolutePath
            ): ?string {
                if (
                    !$absolutePath
                    || !is_file($absolutePath)
                    || !is_readable($absolutePath)
                ) {
                    return null;
                }

                $extension = strtolower(
                    pathinfo(
                        $absolutePath,
                        PATHINFO_EXTENSION
                    )
                );

                $mime = match ($extension) {
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/jpeg',
                };

                $contents = @file_get_contents(
                    $absolutePath
                );

                if ($contents === false) {
                    return null;
                }

                return 'data:' .
                    $mime .
                    ';base64,' .
                    base64_encode($contents);
            };

            /*
             * Produce a centered square crop and transparent circular PNG.
             *
             * This avoids mPDF's inconsistent CSS image clipping and ensures
             * the focal-point portrait remains circular in the generated PDF.
             */
            $photoToCircularDataUri = static function (
                ?string $absolutePath
            ) use ($fileToDataUri): ?string {
                if (
                    !$absolutePath
                    || !is_file($absolutePath)
                    || !is_readable($absolutePath)
                    || !extension_loaded('gd')
                ) {
                    return $fileToDataUri(
                        $absolutePath
                    );
                }

                $extension = strtolower(
                    pathinfo(
                        $absolutePath,
                        PATHINFO_EXTENSION
                    )
                );

                $source = match ($extension) {
                    'png' => @imagecreatefrompng(
                        $absolutePath
                    ),

                    'gif' => @imagecreatefromgif(
                        $absolutePath
                    ),

                    'webp' => function_exists(
                        'imagecreatefromwebp'
                    )
                        ? @imagecreatefromwebp(
                            $absolutePath
                        )
                        : false,

                    default => @imagecreatefromjpeg(
                        $absolutePath
                    ),
                };

                if (!$source) {
                    return $fileToDataUri(
                        $absolutePath
                    );
                }

                $sourceWidth = imagesx($source);
                $sourceHeight = imagesy($source);
                $cropSize = min(
                    $sourceWidth,
                    $sourceHeight
                );

                $sourceX = (int) floor(
                    ($sourceWidth - $cropSize) / 2
                );

                $sourceY = (int) floor(
                    ($sourceHeight - $cropSize) / 2
                );

                $outputSize = 600;

                $square = imagecreatetruecolor(
                    $outputSize,
                    $outputSize
                );

                imagealphablending(
                    $square,
                    false
                );

                imagesavealpha(
                    $square,
                    true
                );

                $transparent = imagecolorallocatealpha(
                    $square,
                    0,
                    0,
                    0,
                    127
                );

                imagefill(
                    $square,
                    0,
                    0,
                    $transparent
                );

                imagecopyresampled(
                    $square,
                    $source,
                    0,
                    0,
                    $sourceX,
                    $sourceY,
                    $outputSize,
                    $outputSize,
                    $cropSize,
                    $cropSize
                );

                /*
                 * Clear all pixels outside the circular portrait.
                 */
                $center = $outputSize / 2;
                $radius = ($outputSize / 2) - 2;

                imagealphablending(
                    $square,
                    false
                );

                for ($y = 0; $y < $outputSize; $y++) {
                    for ($x = 0; $x < $outputSize; $x++) {
                        $distance = sqrt(
                            (($x - $center) ** 2) +
                            (($y - $center) ** 2)
                        );

                        if ($distance > $radius) {
                            imagesetpixel(
                                $square,
                                $x,
                                $y,
                                $transparent
                            );
                        }
                    }
                }

                ob_start();
                imagepng($square);
                $contents = ob_get_clean();

                imagedestroy($source);
                imagedestroy($square);

                if (!$contents) {
                    return $fileToDataUri(
                        $absolutePath
                    );
                }

                return 'data:image/png;base64,' .
                    base64_encode($contents);
            };

            $logoData = $fileToDataUri(
                public_path('images/logo.png')
            );

            $photoPath = $focalPoint->photo_path
                ? public_path(
                    'storage/' .
                    ltrim(
                        $focalPoint->photo_path,
                        '/'
                    )
                )
                : null;

            $photoData = $photoToCircularDataUri(
                $photoPath
            );

            $tempDir = storage_path(
                'app/mpdf'
            );

            if (!is_dir($tempDir)) {
                mkdir(
                    $tempDir,
                    0755,
                    true
                );
            }

            /*
             * One physical portrait card only.
             *
             * This page size must match print.blade.php exactly; otherwise
             * a blank area can appear beside or below the card.
             */
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [53.98, 85.60],
                'orientation' => 'P',

                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,

                'margin_header' => 0,
                'margin_footer' => 0,

                'default_font' => 'dejavusans',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'tempDir' => $tempDir,
            ]);

            $mpdf->SetAutoPageBreak(
                false
            );

            $mpdf->useSubstitutions = true;
            $mpdf->showImageErrors = true;

            $renderedHtml = view(
                'focal-point-cards.print',
                compact(
                    'card',
                    'qr',
                    'logoData',
                    'photoData'
                )
            )->render();

            /*
             * Load CSS separately from the body. Sending the complete HTML
             * document to WriteFixedPosHTML() can display CSS as plain text.
             */
            $css = '';

            if (
                preg_match(
                    '/<style[^>]*>(.*?)<\/style>/is',
                    $renderedHtml,
                    $styleMatch
                )
            ) {
                $css = $styleMatch[1];
            }

            $bodyHtml = $renderedHtml;

            if (
                preg_match(
                    '/<body[^>]*>(.*?)<\/body>/is',
                    $renderedHtml,
                    $bodyMatch
                )
            ) {
                $bodyHtml = $bodyMatch[1];
            }

            if ($css !== '') {
                $mpdf->WriteHTML(
                    $css,
                    HTMLParserMode::HEADER_CSS
                );
            }

            /*
             * Fixed positioning guarantees one card page and clips overflow.
             */
            $mpdf->WriteFixedPosHTML(
                $bodyHtml,
                0,
                0,
                53.98,
                85.60,
                'hidden'
            );

            $pdfContent = $mpdf->Output(
                $card->card_number . '.pdf',
                Destination::STRING_RETURN
            );

            $this->writeAudit(
                'focal_point_card_print_previewed',
                $card,
                null,
                [
                    'card_number' =>
                        $card->card_number,

                    'previewed_by' =>
                        auth()->id(),
                ]
            );

            return response(
                $pdfContent,
                200,
                [
                    'Content-Type' =>
                        'application/pdf',

                    'Content-Disposition' =>
                        'inline; filename="' .
                        $card->card_number .
                        '.pdf"',

                    'Cache-Control' =>
                        'private, no-store, no-cache, must-revalidate',
                ]
            );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                __('messages.card_print_failed')
            );
        }
    }

    /**
     * Mark a card as physically printed.
     */
    public function markPrinted(
        FocalPointCard $card
    ): RedirectResponse {
        if ($card->card_status === 'revoked') {
            return back()->with(
                'error',
                __('messages.revoked_card_cannot_be_marked_printed')
            );
        }

        $oldValues = $card->toArray();

        try {
            DB::transaction(function () use (
                $card,
                $oldValues
            ): void {
                $card->update([
                    'card_status' => $card->issued_at
                        ? 'issued'
                        : 'printed',
                    'printed_at' => now(),
                    'printed_by' => auth()->id(),
                ]);

                $this->writeAudit(
                    'focal_point_card_printed',
                    $card,
                    $oldValues,
                    $card->fresh()->toArray()
                );
            });

            return back()->with(
                'success',
                __('messages.card_printed')
            );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                __('messages.card_mark_printed_failed')
            );
        }
    }

    /**
     * Record physical card handover.
     */
    public function issueCard(
        Request $request,
        FocalPointCard $card
    ): RedirectResponse {
        if ($card->card_status === 'revoked') {
            return back()->with(
                'error',
                __('messages.revoked_card_cannot_be_issued')
            );
        }

        $validated = $request->validate([
            'received_by_name' => [
                'required',
                'string',
                'max:255',
            ],
            'received_at' => [
                'required',
                'date',
            ],
            'issuance_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $oldValues = $card->toArray();

        try {
            DB::transaction(function () use (
                $card,
                $validated,
                $oldValues
            ): void {
                $card->update([
                    'card_status' => 'issued',
                    'issued_at' => $validated['received_at'],
                    'issued_by' => auth()->id(),
                    'received_by_name' =>
                        $validated['received_by_name'],
                    'received_at' => $validated['received_at'],
                ]);

                $this->writeAudit(
                    'focal_point_card_issued',
                    $card,
                    $oldValues,
                    [
                        ...$card->fresh()->toArray(),
                        'issuance_notes' =>
                            $validated['issuance_notes'] ?? null,
                    ]
                );
            });

            return redirect()
                ->route(
                    'focal-points.registration',
                    $card->focal_point_id
                )
                ->with(
                    'success',
                    __('messages.card_issued')
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    __('messages.card_issue_failed')
                );
        }
    }

    /**
     * Revoke a card immediately.
     */
    public function revokeCard(
        Request $request,
        FocalPointCard $card
    ): RedirectResponse {
        if ($card->card_status === 'revoked') {
            return back()->with(
                'warning',
                __('messages.card_already_revoked')
            );
        }

        $validated = $request->validate([
            'revocation_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $oldValues = $card->toArray();

        try {
            DB::transaction(function () use (
                $card,
                $validated,
                $oldValues
            ): void {
                $card->update([
                    'card_status' => 'revoked',
                    'revoked_at' => now(),
                    'revoked_by' => auth()->id(),
                    'revocation_reason' =>
                        $validated['revocation_reason'],
                ]);

                $this->writeAudit(
                    'focal_point_card_revoked',
                    $card,
                    $oldValues,
                    $card->fresh()->toArray()
                );
            });

            return redirect()
                ->route(
                    'focal-points.registration',
                    $card->focal_point_id
                )
                ->with(
                    'success',
                    __('messages.card_revoked')
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    __('messages.card_revoke_failed')
                );
        }
    }

    /**
     * Public QR-code verification page.
     */
    public function verifyCard(
        string $uuid
    ): View {
        $card = FocalPointCard::query()
            ->with('focalPoint.budgetEntity')
            ->where('verification_uuid', $uuid)
            ->first();

        abort_unless(
            $card,
            404,
            __('messages.card_not_found')
        );

        return view(
            'focal-point-cards.verification',
            compact('card')
        );
    }

    /**
     * Validate focal-point registration input.
     *
     * @return array<string, mixed>
     */
    private function validateFocalPoint(
        Request $request,
        ?FocalPoint $focalPoint = null
    ): array {
        $focalPointId = $focalPoint?->id;

        return $request->validate([
            'budget_entity_id' => [
                'required',
                'integer',
                Rule::exists('budget_entities', 'id')
                    ->whereNull('deleted_at'),
            ],
            'introduction_id' => [
                'required',
                'integer',
                Rule::exists(
                    'focal_point_introductions',
                    'id'
                ),
            ],
            'focal_point_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique(
                    'focal_points',
                    'focal_point_code'
                )->ignore($focalPointId),
            ],

            'full_name_en' => [
                'nullable',
                'string',
                'max:255',
            ],
            'full_name_ps' => [
                'nullable',
                'string',
                'max:255',
            ],
            'full_name_fa' => [
                'required',
                'string',
                'max:255',
            ],
            'father_name' => [
                'required',
                'string',
                'max:255',
            ],
            'grandfather_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'employee_number' => [
                'nullable',
                'string',
                'max:100',
            ],
            'national_id' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique(
                    'focal_points',
                    'national_id'
                )->ignore($focalPointId),
            ],

            'job_title' => [
                'required',
                'string',
                'max:255',
            ],
            'directorate' => [
                'nullable',
                'string',
                'max:255',
            ],
            'department' => [
                'nullable',
                'string',
                'max:255',
            ],
            'official_position' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:50',
            ],
            'alternate_phone' => [
                'nullable',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'photo' => [
                $focalPoint ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'signature' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'appointment_date' => [
                'nullable',
                'date',
            ],
            'valid_from' => [
                'required',
                'date',
            ],
            'valid_until' => [
                'required',
                'date',
                'after_or_equal:valid_from',
            ],
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'under_review',
                    'active',
                    'suspended',
                    'replaced',
                    'expired',
                    'rejected',
                    'inactive',
                ]),
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    /**
     * Ensure the selected introduction letter belongs to the selected entity.
     */
    private function ensureIntroductionBelongsToEntity(
        int $introductionId,
        int $budgetEntityId
    ): void {
        $valid = FocalPointIntroduction::query()
            ->whereKey($introductionId)
            ->where(
                'budget_entity_id',
                $budgetEntityId
            )
            ->exists();

        if (!$valid) {
            throw ValidationException::withMessages([
                'introduction_id' => __(
                    'messages.introduction_entity_mismatch'
                ),
            ]);
        }
    }

    /**
     * Generate a readable unique focal-point code.
     */
    private function makeFocalPointCode(
        FocalPoint $focalPoint
    ): string {
        $entityCode = BudgetEntity::query()
            ->whereKey($focalPoint->budget_entity_id)
            ->value('entity_code');

        $entityCode = Str::upper(
            Str::slug($entityCode ?: 'ENTITY', '')
        );

        return sprintf(
            'FPC-%s-%06d',
            $entityCode,
            $focalPoint->id
        );
    }

    /**
     * Generate a readable unique card number.
     */
    private function makeCardNumber(
        FocalPointCard $card,
        FocalPoint $focalPoint,
        string $fiscalYear
    ): string {
        $entityCode = $focalPoint->budgetEntity?->entity_code
            ?: 'ENTITY';

        $entityCode = Str::upper(
            Str::slug($entityCode, '')
        );

        return sprintf(
            'FP-%s-%s-%06d',
            $entityCode,
            $fiscalYear,
            $card->id
        );
    }

    /**
     * Delete a file from the public storage disk when it exists.
     */
    private function deletePublicFile(
        ?string $path
    ): void {
        if (!$path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Safely write to the existing EMIS audit helper when available.
     *
     * @param array<string, mixed>|null $oldValues
     * @param array<string, mixed>|null $newValues
     */
    private function writeAudit(
        string $action,
        object $model,
        ?array $oldValues,
        ?array $newValues
    ): void {
        if (!function_exists('audit_log')) {
            return;
        }

        try {
            audit_log(
                $action,
                $model,
                $oldValues,
                $newValues
            );
        } catch (Throwable $exception) {
            /*
             * Audit failure should be reported, but it must not prevent
             * the main administrative transaction from completing.
             */
            report($exception);
        }
    }
}