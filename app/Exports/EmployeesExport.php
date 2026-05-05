<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class EmployeesExport implements FromCollection, WithMapping, WithStyles, ShouldAutoSize, WithEvents, WithCustomStartCell, WithDrawings
{
    protected $request;
    protected int $rowNumber = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Employee::query();

        if ($this->request->search) {
            $search = $this->request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('employee_code', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($this->request->status) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($this->request->status)]);
        }

        return $query->latest()->get();
    }

    public function startCell(): string
    {
        return 'A6';
    }

 public function map($employee): array
{
    $this->rowNumber++;

    return [
        optional($employee->created_at)->format('Y-m-d H:i'),
        ucfirst($employee->status ?? 'N/A'),
        $employee->phone ?? '-',
        $employee->email ?? '-',
        $employee->full_name,
        $employee->employee_code,
        $this->rowNumber,
    ];
}

    public function drawings()
    {
        $drawings = [];

        $leftLogo = public_path('images/mof-logo.png');
        if (file_exists($leftLogo)) {
            $drawing1 = new Drawing();
            $drawing1->setName('NBD Logo');
            $drawing1->setDescription('National Budget Directorate Logo');
            $drawing1->setPath($leftLogo);
            $drawing1->setHeight(60);
            $drawing1->setCoordinates('A1');
            $drawings[] = $drawing1;
        }

        $rightLogo = public_path('images/IEA.png');
        if (file_exists($rightLogo)) {
            $drawing2 = new Drawing();
            $drawing2->setName('Afghanistan Logo');
            $drawing2->setDescription('Afghanistan National Emblem');
            $drawing2->setPath($rightLogo);
            $drawing2->setHeight(90);
            $drawing2->setCoordinates('G1');
            $drawings[] = $drawing2;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $sheet = $event->sheet->getDelegate();
                   $sheet->setRightToLeft(true);

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(4)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(15);
               
               $sheet->mergeCells('B1:F1');
$sheet->mergeCells('B2:F2');
$sheet->mergeCells('B3:F3');

$sheet->setCellValue('B1', 'د مالیې وزارت');
$sheet->setCellValue('B2', 'د ملي بودیجې لوی ریاست');
$sheet->setCellValue('B3', 'د کارکوونکو راپور');

$sheet->setCellValue('A4', now()->format('Y-m-d H:i'));
$sheet->setCellValue('B4', 'د راپور د جوړېدو وخت:');
              
                $sheet->setCellValue('G4', now()->format('Y-m-d H:i'));
                  $sheet->setCellValue('F4', 'نېټه:');

            $sheet->fromArray([
                  ['د جوړېدو نېټه', 'حالت', 'تلیفون', 'برېښنالیک', 'بشپړ نوم', 'کوډ', 'شمېره']
                  ], null, 'A5');


                $sheet->getStyle('B1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                        'color' => ['rgb' => '1F1F1F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('B2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => '333333'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('B3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                        'color' => ['rgb' => '333333'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('F4:G4')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 11,
                        'color' => ['rgb' => '555555'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);

                $sheet->getStyle('A5:G5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1F4E78'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'FFFFFF'],
                        ],
                    ],
                ]);

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 6) {
                    $sheet->getStyle("A6:G{$highestRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'D9D9D9'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    $sheet->getStyle("A6:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("B6:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("F6:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("G6:G{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    for ($row = 6; $row <= $highestRow; $row++) {
                        if ($row % 2 == 0) {
                            $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'F8FBFF'],
                                ],
                            ]);
                        }

                        $statusValue = strtolower(trim((string) $sheet->getCell("F{$row}")->getValue()));

                        if ($statusValue === 'active') {
                            $sheet->getStyle("F{$row}")->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => 'FFFFFF'],
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => '28A745'],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                        } elseif ($statusValue === 'inactive') {
                            $sheet->getStyle("F{$row}")->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => 'FFFFFF'],
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'DC3545'],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                        } else {
                            $sheet->getStyle("F{$row}")->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => 'FFFFFF'],
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => '6C757D'],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                        }
                    }
                }

                $sheet->freezePane('A6');

                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setTop(0.4);
                $sheet->getPageMargins()->setRight(0.3);
                $sheet->getPageMargins()->setLeft(0.3);
                $sheet->getPageMargins()->setBottom(0.4);
            },
        ];
    }
}