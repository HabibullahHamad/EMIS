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
.tb{
 background-color: #074582;
 padding: 1px 8px 1px 8px;
 border-radius:6px;
 color:white;
 weight:10px;
 margin-right:3px;
 }
    </style>

<div class="d-flex justify-content-start mb-1 mt-0">

    <a href="{{ route('CorrespondenceManagement.inbox.form') }}" class="tb">
        <i class="fa fa-plus"></i>
    </a>

    <a href="{{route('inbox.index')}}" class="tb">
        <i class="fa fa-search"></i>
    </a>
</div>
<hr>
<style>
    .form-card {
        max-width: 1000px;
        margin: 60px auto;
        padding: 30px 40px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        font-family: 'Poppins', sans-serif;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
    }
    .input-group .form-control {
        border-radius: 6px;
        transition: box-shadow 0.3s;
    }
    .input-group .form-control:focus {
        box-shadow: 0 0 0 1px #0685ed;
    }
    .save-btn {
        background: #0685ed;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 24px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .save-btn:hover {
        background: #138496;
    }
    @media (max-width: 768px) {
        .form-card {
            padding: 15px 8px;
        }
    }
</style>

<form action="{{ route('inbox.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- All your input fields here -->

<div class="container mt-0 mb-0 border-3 form-card">


    <div class=".col-sm-3 .col-md-4 .col-lg-4">     
       
        <div class="row g-2">
            {{-- Letter Number --}}
            <div class="col-md-6 mb-0">
                <label class="form-label">ګنه</label>
                <div class="input-group">
                   
                    <input type="text" name="letter_no" class="form-control"
                        value="{{ $inbox->letter_no ?? old('letter_no') }}">
                </div>
            </div>

            {{-- Subject --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">موضوع</label>
                <div class="input-group">
                    
                    <input type="text" name="subject" class="form-control"
                        value="{{ $inbox->subject ?? old('subject') }}">
                </div>
            </div>

            {{-- Sender Name --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">لېږونکی</label>
                <div class="input-group">
                  
                    
                        <input type="text" name="sender" class="form-control"
                           value="{{ old('sender') }}">
                </div>
                
            </div>
  {{-- Reciver Name --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">ترلاسه کوونکې</label>
                <div class="input-group">
                  
                    
                        <input type="text" name="receiver" class="form-control"
                           value="{{ old('receiver') }}">
                </div>
                
            </div>
            {{-- Date Received --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">ترلاسه کېدو نېټه</label>
                <div class="input-group">
                    
                    <input type="date" name="received_date" class="form-control">
                </div>
            </div>
 {{-- summary --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">ترلاسه کوونکې</label>
                <div class="input-group">
                    
                        <input type="text" name="summary" class="form-control"
                           value="{{ old('summary') }}">
                </div>
                
            </div>
  
    
            {{-- File --}}
            <div class="col-md-6 mb-1">
                <label class="form-label">مل/ضمایم</label>
                <div class="input-group">
                   
                    <input type="file" name="attachment" class="form-control">
                </div>
            </div>

           

        </div>
       
        <div class="row mt-3">
            <div class="col-md-12 text-center">             
                <button type="submit" class="save-btn">
                     لیک خوندي کړئ
                </button>

            </div>
    </div>
    
</div>
</form>
@endsection
