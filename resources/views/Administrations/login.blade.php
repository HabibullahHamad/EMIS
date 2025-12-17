<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta charset="UTF-8">
    <title>EMIS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            height: 400px;
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 30px 30px ;
            border-radius: 30px 0px 30px 0px;
            margin: 14px;
            position: relative;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .logo {
           
            display: block;
            margin: 0 auto 1px auto;
            width: 90px;
            position:top 0px;

        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 0px;
            color: #1e3c72;
            font-weight: 600;
        }

        .login-box p {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-bottom: 0px;
         
        }
        .form-group {
            margin-bottom: 0px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #444;
            
        }

        .form-group input {
            width: 100%;
            padding: 8px 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s;
            
        }

        .form-group input:focus {
            border-color: #2a5298;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #1e3c72;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
          
            transition: 0.3s;
         
        }

        .btn-login:hover {
            background: #142850;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .links a {
            font-size: 13px;
            color: #1e3c72;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .error {
            background: #fdecea;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: center;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #5d5e63ff;
        }

        @media (max-width: 480px) {
            .login-box {
                margin: 2px;
            }
        }
    </style>
</head>
<body>

<div class="login-box">

    <img src="{{ asset('images/45.png') }}" alt="EMIS Logo" class="logo">

    <h2>EMIS Login</h2>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="#">
        @csrf

        <div class="form-group">
            <label>Username or Email</label>
            <input type="text" name="email" required autofocus>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>

       

    </form>

    <div class="footer-text">
        © {{ date('Y') }} EMIS – Authorized Access Only , Developed By DGB IT Team
    </div>

</div>

</body>
</html>
