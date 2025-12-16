@extends('new')
@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script>
// SVG fallback for icons if FontAwesome is not loaded
function svgFor(name, type, tag) {
    // Use FontAwesome classes for icons
    const iconMap = {
        letter_no: '<i class="fa-solid fa-hashtag"></i>',
        subject: '<i class="fa-solid fa-file-lines"></i>',
        sender: '<i class="fa-solid fa-user"></i>',
        received_date: '<i class="fa-solid fa-calendar-day"></i>',
        priority: '<i class="fa-solid fa-arrow-up"></i>',
        read_status: '<i class="fa-solid fa-eye"></i>',
        attachment: '<i class="fa-solid fa-paperclip"></i>'
    };
    return iconMap[name] || '<i class="fa-solid fa-pen"></i>';
}
</script>
<style>
/* Rounded, animated form container */
.styled-form{
    background: #cfcdcdff;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(18, 38, 63, 0.08);
    animation: fadeInUp .5s ease both;
    margin-top: 8px;
}

/* Two-column layout (falls to one column on small screens) */
.styled-grid{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
@media (max-width: 768px){
    .styled-grid{ grid-template-columns: 1fr; }
}

/* Icon container & input padding */
.field-with-icon{ position: relative; }
.field-with-icon .form-control,
.field-with-icon select{
    padding-left: 40px;
    border-radius: 8px;
    height: calc(1.6em + .75rem + 2px);
}

/* icon position */
.field-icon{
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    opacity: .9;
}

/* make file & full-width items span both columns */
.full-span{ grid-column: 1 / -1; }

/* Submit styling & small lift animation */
.form-actions{
    display: flex;
    gap: 12px;
    align-items: center;
    margin-top: 12px;
}
button.btn-primary{
    border-radius: 8px;
    transition: transform .12s ease, box-shadow .12s ease;
}
button.btn-primary:hover{ transform: translateY(-3px); box-shadow: 0 6px 18px rgba(18,38,63,.08); }

@keyframes fadeInUp{
    from{ opacity: 0; transform: translateY(10px); }
    to{ opacity: 1; transform: translateY(0); }
}

/* Small tweak so the file input text doesn't overlap the icon on Win/Chrome */
input[type="file"].form-control{ padding-left: 40px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // find the main form in the container
    const form = document.querySelector('.container form');
    if(!form) return;
    form.classList.add('styled-form');

    // collect field blocks and create a grid wrapper
    const blocks = Array.from(form.querySelectorAll('.mb-3'));
    const grid = document.createElement('div');
    grid.className = 'styled-grid';

    // placeholders and icon map (fallback icons)
    const placeholders = {
        letter_no: 'Enter letter number',
        subject: 'Enter subject',
        sender: 'Enter sender name',
        received_date: 'Select received date',
        priority: 'Select priority',
        read_status: 'Select status',
        attachment: 'Choose file'
    };


    // Process each .mb-3: add icon wrapper, placeholders, and decide full-span
    blocks.forEach(function(block){
        const control = block.querySelector('input, select, textarea, .form-control');
        // add icon wrapper only if control exists
        if(control){
            block.classList.add('field-with-icon');

            // create icon element
            const icon = document.createElement('span');
            icon.className = 'field-icon';
            const name = control.name || control.id || '';
            icon.innerHTML = svgFor(name, control.type, control.tagName.toLowerCase());

            // insert icon before control
            block.insertBefore(icon, control);

            // set placeholder for inputs/textareas
            if(control.tagName.toLowerCase() === 'input' || control.tagName.toLowerCase() === 'textarea'){
                const ph = placeholders[control.name] || control.getAttribute('placeholder') || '';
                if(ph) control.placeholder = ph;
            }

            // for selects: insert a disabled placeholder option if none selected
            if(control.tagName.toLowerCase() === 'select'){
                const opts = Array.from(control.options);
                const hasRealSelected = opts.some(o => o.selected && o.value !== '');
                if(!hasRealSelected){
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.text = placeholders[control.name] || 'Select';
                    opt.disabled = true;
                    opt.selected = true;
                    control.insertBefore(opt, control.firstChild);
                }
            }
        }

        // file inputs and the attachment block should span both columns
        if(block.querySelector('input[type="file"]') || (block.querySelector('label') && /attachment/i.test(block.innerText))){
            block.classList.add('full-span');
        }

        // append to grid
        grid.appendChild(block);
    });

    // insert grid before the form's submit button
    const submit = form.querySelector('button[type="submit"]');
    if(submit){
        form.insertBefore(grid, submit);

        // wrap submit into actions container and make it full-width
        const actions = document.createElement('div');
        actions.className = 'form-actions full-span';
        actions.appendChild(submit);
        form.appendChild(actions);
    } else {
        // no submit found: just append grid
        form.appendChild(grid);
    }
});
</script>
<div class="container mt-4">
   

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <div style="margin-top: 2px; background-color: #9c8304ff; padding: 2px; border-radius: 10px 10px 0px 0px; text-align: center;"> <h2 style="color: #07079dff; align: center;">Add New Letter</h2></div>
    <form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Letter Number --}}
        <div class="mb-3">
            <label for="letter_no" class="form-label">Letter Number</label>
            <input type="text" name="letter_no" id="letter_no" class="form-control" value="{{ old('letter_no') }}" required>
        </div>

        {{-- Subject --}}
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
        </div>

        {{-- Sender --}}
        <div class="mb-3">
            <label for="sender" class="form-label">Sender</label>
            <input type="text" name="sender" id="sender" class="form-control" value="{{ old('sender') }}" required>
        </div>

        {{-- Received Date --}}
        <div class="mb-3">
            <label for="received_date" class="form-label">Received Date</label>
            <input type="date" name="received_date" id="received_date" class="form-control" value="{{ old('received_date') }}" required>
        </div>

        
        {{-- Priority --}}

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" id="priority" class="form-control">
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>
          {{-- Status --}}
        <div class="mb-3">
            <label for="read_status" class="form-label">Read Status</label>
            <select name="read_status" id="read_status" class="form-control">
                <option value="Unread" {{ old('read_status') == 'Unread' ? 'selected' : '' }}>Unread</option>
                <option value="Read" {{ old('read_status') == 'Read' ? 'selected' : '' }}>Read</option>
                <option value="Assigned" {{ old('read_status') == 'Assigned' ? 'selected' : '' }}>Assigned</option>
                <option value="Completed" {{ old('read_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
      
        {{-- Attachment --}}
        <div class="mb-3">
            <label for="attachment" class="form-label">Attachment</label>
            <input type="file" name="attachment" id="attachment" class="form-control">
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Save Letter</button>
        
    <!-- Toast -->
  
    <!-- end soat -->
    
    </form>
</div>


@endsection
