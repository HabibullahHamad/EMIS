@extends('new')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script>
    $("#deadline").persianDatepicker({
        format: 'YYYY/MM/DD',
        altField: '#deadline_hidden',
        altFormat: 'YYYY/MM/DD',
        observer: true,
        autoClose: true
    });
</script>
<style>

    .div1{
         background: #2e97e7;
        padding: 3px;
       
        
    }
    body {
        font-family: "Times New Roman", Times, serif;

    }

    .form-card {
        background: #ffffff;
        padding: 12px;
        border-radius: 1px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
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
       
        font-size: 12px;
        align:center;
    }

    .save-btn:hover {
        
        background: linear-gradient(90deg, #0056b3, #004599);
    }
</style>
<form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- All your input fields here -->

         



<div class="container mt-2 mb-2 border-3 form-card">

    <div class="col-md-14 mx-auto">

        <div class="div1">
            📩 نوی لیک خوندي کړئ
        </div>
        <div class="row">
            {{-- Letter Number --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">ګنه</label>
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
                <label class="form-label">موضوع</label>
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
                <label class="form-label">لېږونکی</label>
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
                <label class="form-label">ترلاسه کېدو نېټه</label>
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
                <label class="form-label">لومړیتوب</label>
                <div class="input-group">
                    <span class="input-group-text">
                        ⚠️
                    </span>
                    <select name="priority" class="form-control">
                        <option value="لوړ">لوړ</option>
                        <option value="منځنی">منځنی</option>
                        <option value="lټیټw">ټیټ</option>
                    </select>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">حالت</label>
                <div class="input-group">
                    <span class="input-group-text">
                        🔄
                    </span>
                    <select name="status" class="form-control">
                        <option value="نوی">نوی</option>
                        <option value="په جریان کې">په جریان کې</option>
                        <option value="بشپړ">بشپړ</option>
                    </select>
                </div>
            </div>
            {{-- File --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">مل/ضمایم</label>
                <div class="input-group">
                    <span class="input-group-text">
                        📎
                    </span>
                    <input type="file" name="attachment" class="form-control">
                </div>
            </div>

            <div class="col-md-4 text-end mt-1">
                <button type="submit" class="save-btn">
                    💾 لیک خوندي کړئ
                </button>
            </div>

        </div>
    </div>
</div>
</form>
@endsection
