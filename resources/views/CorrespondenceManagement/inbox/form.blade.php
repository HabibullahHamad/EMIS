@extends('new')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .form-card {
        background: #ffffff;
        padding: 35px;
        border-radius: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        animation: slideUp 0.7s ease-out;
    }

    @keyframes slideUp {
        from { transform: translateY(40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .form-header {
        background: linear-gradient(90deg, #007bff, #0056b3);
        padding: 18px 25px;
        border-radius: 16px;
        color: #fff;
        margin-bottom: 30px;
        font-size: 15px;
        font-weight: 200;
        letter-spacing: .2px;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .input-group-text {
        background: #eef3ff;
        border: 1px solid #d2d9ff;
        font-weight: 600;
        color: #0056b3;
    }

    .form-control {
        border-radius: 10px;
        transition: .3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0,123,255,0.3);
    }

    .save-btn {
        background: linear-gradient(90deg, #007bff, #0056b3);
        color: #fff;
        padding: 10px 40px;
        border-radius: 35px;
        border: none;
        font-weight: 600;
        letter-spacing: .5px;
        transition: 0.3s;
        font-size: 17px;
    }

    .save-btn:hover {
        transform: scale(1.08);
        background: linear-gradient(90deg, #0056b3, #004599);
    }
</style>
<form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- All your input fields here -->

<div class="container mt-4 mb-4">

    <div class="col-md-10 mx-auto form-card">

        <div class="form-header">
            📩 Add New Incoming Letter
        </div>

        <div class="row">

            {{-- Letter Number --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Letter No</label>
                <div class="input-group">
                    <span class="input-group-text">
                        🔢
                    </span>
                    <input type="text" name="letter_no" class="form-control"
                        value="{{ $inbox->letter_no ?? old('letter_no') }}">
                </div>
            </div>

            {{-- Subject --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Subject</label>
                <div class="input-group">
                    <span class="input-group-text">
                        📝
                    </span>
                    <input type="text" name="subject" class="form-control"
                        value="{{ $inbox->subject ?? old('subject') }}">
                </div>
            </div>

            {{-- Sender Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Sender Name</label>
                <div class="input-group">
                    <span class="input-group-text">
                        👤
                    </span>
                    <input type="text" name="sender_name" class="form-control"
                        value="{{ $inbox->sender_name ?? old('sender_name') }}">
                </div>
            </div>

            {{-- Date Received --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Date Received</label>
                <div class="input-group">
                    <span class="input-group-text">
                        📅
                    </span>
                    <input type="date" name="date_received" class="form-control"
                        value="{{ $inbox->date_received ?? old('date_received') }}">
                </div>
            </div>

            {{-- Priority --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Priority</label>
                <div class="input-group">
                    <span class="input-group-text">
                        ⚠️
                    </span>
                    <select name="priority" class="form-control">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <div class="input-group">
                    <span class="input-group-text">
                        🔄
                    </span>
                    <select name="status" class="form-control">
                        <option value="new">New</option>
                        <option value="in_review">In Review</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            {{-- File --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Attachment</label>
                <div class="input-group">
                    <span class="input-group-text">
                        📎
                    </span>
                    <input type="file" name="attachment" class="form-control">
                </div>
            </div>

            <div class="col-md-12 text-end mt-3">
                <button type="submit" class="save-btn">
                    💾 Save Letter
                </button>
            </div>

        </div>
    </div>
</div>
</form>
@endsection
