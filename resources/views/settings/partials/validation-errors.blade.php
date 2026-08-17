@if($errors->any())

    <div
        class="settings-validation-errors"
        role="alert"
    >

        <div class="settings-validation-errors__header">

            <i class="fa-solid fa-triangle-exclamation"></i>

            <strong>
                {{
                    __('emis.validation_errors')
                    !== 'emis.validation_errors'
                        ? __('emis.validation_errors')
                        : 'Please correct the following errors.'
                }}
            </strong>

        </div>

        <ul class="settings-validation-errors__list">

            @foreach($errors->all() as $error)

                <li>

                    {{ $error }}
                    
                </li>

            @endforeach

        </ul>

    </div>

@endif

@push('styles')

<style>

    .settings-validation-errors {
        margin-bottom: 18px;
        padding: 13px 15px;

        border:
            1px solid
            #fecaca;

        border-radius: 10px;

        background: #fef2f2;

        color: #991b1b;
    }

    .settings-validation-errors__header {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 8px;

        font-size: 13px;
    }

    .settings-validation-errors__list {
        margin: 0;
        padding-inline-start: 21px;

        font-size: 12px;
        line-height: 1.7;
    }

</style>

@endpush