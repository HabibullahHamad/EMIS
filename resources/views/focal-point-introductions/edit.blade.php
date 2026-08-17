@extends('new')

@section('title', __('emis.edit_introduction_letter'))

@section('content')
@php $statuses = ['received','under_review','returned','approved','rejected','completed']; @endphp
<div class="container-fluid emis-page">
    <x-emis.page-header :title="__('emis.edit_introduction_letter')" :description="$introduction->letter_number" icon="fa-solid fa-envelope-open-text">
        <x-slot:actions><a href="{{ route('focal-point-introductions.show', $introduction) }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i>{{ __('emis.back') }}</a></x-slot:actions>
    </x-emis.page-header>
    <x-emis.card :title="__('emis.official_introduction')">
        <form method="POST" enctype="multipart/form-data" action="{{ route('focal-point-introductions.update', $introduction) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">{{ __('emis.budget_entity') }} *</label><select name="budget_entity_id" class="form-select" required>@foreach($budgetEntities as $entity)<option value="{{ $entity->id }}" @selected((string)old('budget_entity_id',$introduction->budget_entity_id)===(string)$entity->id)>{{ $entity->entity_code }} — {{ $entity->display_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.incoming_document_reference') }}</label><select name="inbox_id" class="form-select"><option value="">—</option>@foreach($inboxes as $inbox)<option value="{{ $inbox->id }}" @selected((string)old('inbox_id',$introduction->inbox_id)===(string)$inbox->id)>{{ $inbox->document_number ?? $inbox->letter_number ?? ('#'.$inbox->id) }} — {{ $inbox->subject ?? '' }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.letter_number') }} *</label><input name="letter_number" value="{{ old('letter_number',$introduction->letter_number) }}" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.letter_date') }} *</label><input type="date" name="letter_date" value="{{ old('letter_date',optional($introduction->letter_date)->format('Y-m-d')) }}" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.received_date') }} *</label><input type="date" name="received_date" value="{{ old('received_date',optional($introduction->received_date)->format('Y-m-d')) }}" class="form-control" required></div>
                <div class="col-md-8"><label class="form-label">{{ __('emis.subject') }} *</label><input name="subject" value="{{ old('subject',$introduction->subject) }}" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">{{ __('emis.number_of_nominees') }} *</label><input type="number" min="1" max="50" name="number_of_nominees" value="{{ old('number_of_nominees',$introduction->number_of_nominees) }}" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.status') }} *</label><select name="status" class="form-select">@foreach($statuses as $status)<option value="{{ $status }}" @selected(old('status',$introduction->status)===$status)>{{ __('emis.'.$status) }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">{{ __('emis.attachment') }}</label><input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="form-control"><div class="form-text">{{ __('emis.replace_file_note') }}</div></div>
                <div class="col-12"><label class="form-label">{{ __('emis.approval_notes') }}</label><textarea name="approval_notes" class="form-control">{{ old('approval_notes',$introduction->approval_notes) }}</textarea></div>
            </div>
            <div class="emis-action-bar"><a href="{{ route('focal-point-introductions.show',$introduction) }}" class="btn btn-secondary">{{ __('emis.cancel') }}</a><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>{{ __('emis.update') }}</button></div>
        </form>
    </x-emis.card>
</div>
@endsection
