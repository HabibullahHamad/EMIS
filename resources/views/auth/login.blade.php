<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMIS Login</title>
    <style>
        body{
            margin:0;
            padding:0;
            font-family:Arial, sans-serif;
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .login-box{
            width:380px;
            background:#fff;
            padding:28px;
            border-radius:12px;
            box-shadow:0 4px 18px rgba(0,0,0,0.08);
        }
        .login-box h2{
            margin:0 0 8px 0;
            text-align:center;
            color:#1f3c88;
        }
        .login-box p{
            margin:0 0 20px 0;
            text-align:center;
            color:#666;
            font-size:14px;
        }
        .form-group{
            margin-bottom:16px;
        }
        label{
            display:block;
            margin-bottom:6px;
            font-size:14px;
            font-weight:600;
        }
        input[type="email"],
        input[type="password"]{
            width:100%;
            padding:10px 12px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:14px;
            box-sizing:border-box;
        }
        .remember{
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:16px;
            font-size:14px;
        }
        button{
            width:100%;
            padding:11px;
            border:none;
            border-radius:8px;
            background:#0d6efd;
            color:#fff;
            font-size:15px;
            cursor:pointer;
        }
        button:hover{
            background:#0b5ed7;
        }
        .error{
            background:#f8d7da;
            color:#842029;
            padding:10px 12px;
            border-radius:8px;
            margin-bottom:14px;
            font-size:14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>EMIS</h2>
        <p>Executive Management Information System</p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin:0;font-weight:normal;">Remember me</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>