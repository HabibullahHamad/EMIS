@php
    /*
    |--------------------------------------------------------------------------
    | Expected optional variables
    |--------------------------------------------------------------------------
    |
    | $formId
    | $cancelUrl
    | $saveLabel
    |
    */

    $formId = $formId
        ?? 'settings-section-form';

    $cancelUrl = $cancelUrl
        ?? route('settings.overview');

    $resolveActionText = function (
        mixed $key,
        string $fallback
    ): string {
        if (!is_string($key) || trim($key) === '') {
            return $fallback;
        }

        $translated = __($key);

        return $translated === $key
            ? $fallback
            : $translated;
    };

    $resolvedSaveLabel = $resolveActionText(
        $saveLabel ?? 'emis.save_settings',
        'Save Settings'
    );

    $cancelLabel = $resolveActionText(
        'emis.cancel',
        'Cancel'
    );

    $resetLabel = $resolveActionText(
        'emis.reset_changes',
        'Reset Changes'
    );

    $savedStateLabel = $resolveActionText(
        'emis.no_unsaved_changes',
        'No unsaved changes'
    );

    $changedStateLabel = $resolveActionText(
        'emis.unsaved_changes',
        'Unsaved changes'
    );
@endphp

<div
    class="settings-actions"
    data-settings-actions
    data-clean-label="{{ $savedStateLabel }}"
    data-dirty-label="{{ $changedStateLabel }}"
>
    <div class="settings-actions__status">
        <span
            class="settings-actions__status-dot"
            aria-hidden="true"
        ></span>

        <span data-settings-status>
            {{ $savedStateLabel }}
        </span>
    </div>

    <div class="settings-actions__buttons">
        <button
            type="reset"
            form="{{ $formId }}"
            class="settings-actions__button settings-actions__button--light"
        >
            <i class="fa-solid fa-rotate-left"></i>
            <span>{{ $resetLabel }}</span>
        </button>

        <a
            href="{{ $cancelUrl }}"
            class="settings-actions__button settings-actions__button--light"
        >
            <i class="fa-solid fa-xmark"></i>
            <span>{{ $cancelLabel }}</span>
        </a>

        <button
            type="submit"
            form="{{ $formId }}"
            class="settings-actions__button settings-actions__button--primary"
            data-settings-submit
        >
            <i class="fa-solid fa-floppy-disk"></i>
            <span>{{ $resolvedSaveLabel }}</span>
        </button>
    </div>
</div>

@once
    @push('styles')
        <style>
            .settings-actions {
                position: sticky;
                bottom: 0;
                z-index: 20;

                display: flex;
                align-items: center;
                justify-content: space-between;

                gap: 16px;

                margin-top: 22px;
                padding: 13px 16px;

                background:
                    rgba(255, 255, 255, 0.97);

                border: 1px solid #e1e6ee;
                border-radius: 10px;

                box-shadow:
                    0 -5px 18px
                    rgba(31, 41, 55, 0.06);

                backdrop-filter: blur(8px);
            }

            .settings-actions__status {
                display: flex;
                align-items: center;

                gap: 7px;

                color: #68758a;

                font-size: 11.5px;
                font-weight: 600;
            }

            .settings-actions__status-dot {
                width: 8px;
                height: 8px;

                flex: 0 0 8px;

                background: #22c55e;

                border-radius: 50%;
            }

            .settings-actions.is-dirty
            .settings-actions__status {
                color: #b45309;
            }

            .settings-actions.is-dirty
            .settings-actions__status-dot {
                background: #f59e0b;
            }

            .settings-actions__buttons {
                display: flex;
                align-items: center;

                gap: 8px;
            }

            .settings-actions__button {
                min-height: 38px;

                display: inline-flex;
                align-items: center;
                justify-content: center;

                gap: 7px;

                padding: 8px 13px;

                border: 1px solid transparent;
                border-radius: 8px;

                font-size: 12px;
                font-weight: 700;

                text-decoration: none;
                cursor: pointer;

                transition:
                    background-color 0.2s ease,
                    border-color 0.2s ease,
                    transform 0.2s ease;
            }

            .settings-actions__button:hover {
                transform: translateY(-1px);
                text-decoration: none;
            }

            .settings-actions__button--light {
                color: #526074;
                background: #ffffff;

                border-color: #dce2ea;
            }

            .settings-actions__button--light:hover {
                color: #24324a;
                background: #f7f9fc;
                border-color: #cbd3df;
            }

            .settings-actions__button--primary {
                color: #ffffff;
                background: #173d7a;

                border-color: #173d7a;
            }

            .settings-actions__button--primary:hover {
                color: #ffffff;
                background: #102f61;
                border-color: #102f61;
            }

            .settings-actions__button:disabled {
                opacity: 0.65;
                cursor: wait;
                transform: none;
            }

            @media (max-width: 720px) {
                .settings-actions {
                    position: static;

                    flex-direction: column;
                    align-items: stretch;
                }

                .settings-actions__buttons {
                    display: grid;
                    grid-template-columns: 1fr;
                }

                .settings-actions__button {
                    width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function () {
                    const forms =
                        document.querySelectorAll(
                            'form[data-settings-form]'
                        );

                    forms.forEach(function (form) {
                        const formId = form.id;

                        const actionBar =
                            document.querySelector(
                                '[data-settings-actions]'
                            );

                        if (!actionBar || !formId) {
                            return;
                        }

                        const status =
                            actionBar.querySelector(
                                '[data-settings-status]'
                            );

                        const submitButton =
                            actionBar.querySelector(
                                '[data-settings-submit]'
                            );

                        const cleanLabel =
                            actionBar.dataset.cleanLabel
                            || 'No unsaved changes';

                        const dirtyLabel =
                            actionBar.dataset.dirtyLabel
                            || 'Unsaved changes';

                        let isDirty = false;
                        let isSubmitting = false;

                        const updateState =
                            function (dirty) {
                                isDirty = dirty;

                                actionBar.classList.toggle(
                                    'is-dirty',
                                    dirty
                                );

                                if (status) {
                                    status.textContent =
                                        dirty
                                            ? dirtyLabel
                                            : cleanLabel;
                                }
                            };

                        form.addEventListener(
                            'input',
                            function () {
                                updateState(true);
                            }
                        );

                        form.addEventListener(
                            'change',
                            function () {
                                updateState(true);
                            }
                        );

                        form.addEventListener(
                            'reset',
                            function () {
                                window.setTimeout(
                                    function () {
                                        updateState(false);
                                    },
                                    0
                                );
                            }
                        );

                        form.addEventListener(
                            'submit',
                            function () {
                                isSubmitting = true;
                                updateState(false);

                                if (submitButton) {
                                    submitButton.disabled = true;
                                }
                            }
                        );

                        window.addEventListener(
                            'beforeunload',
                            function (event) {
                                if (!isDirty || isSubmitting) {
                                    return;
                                }

                                event.preventDefault();
                                event.returnValue = '';
                            }
                        );
                    });
                }
            );
        </script>
    @endpush
@endonce