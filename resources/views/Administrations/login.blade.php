@extends('new')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMIS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
           
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content:absolute;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            padding-left:230px;
            margin-left: 220px;
            width: 380px;
            background: #ffffff;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background: #2c3e50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #1a252f;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }

     
    </style>
</head>
<body>

<div class="login-box">
    <h2>EMIS Login</h2>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="form-group">
            <label>Username or Email</label>
            <input type="text" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="footer-text">
        © {{ date('Y') }} EMIS – Authorized Access Only
    </div>
</div>

</body>
</html>
@endsection
