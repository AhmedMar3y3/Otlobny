<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register</title>
    <!-- Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Colors */
        body {
            font-family: 'Asap', sans-serif;
        }

        .login {
            overflow: hidden;
            background-color: rgba(2, 128, 144, 0.2);
            padding: 40px 30px 30px 30px;
            border-radius: 10px;
            position: absolute;
            top: 55%;
            left: 50%;
            width: 400px;
            transform: translate(-50%, -50%);
            transition: transform 300ms, box-shadow 300ms;
            box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2);
        }
        .login::before,
        .login::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-top-left-radius: 40%;
            border-top-right-radius: 45%;
            border-bottom-left-radius: 35%;
            border-bottom-right-radius: 40%;
            z-index: -1;
        }

        .login::before {
            left: 40%;
            bottom: -130%;
            background-color: rgba(69, 105, 144, 0.15);
            animation: wawes 6s infinite linear;
        }

        .login::after {
            left: 35%;
            bottom: -125%;
            background-color: rgba(2, 128, 144, 0.2);
            animation: wawes 7s infinite linear;
        }

        .login>input {
            font-family: 'Asap', sans-serif;
            display: block;
            border-radius: 5px;
            font-size: 16px;
            background: white;
            width: 100%;
            border: 0;
            padding: 10px 10px;
            margin: 15px -10px;
        }

        .register-btn, .login-btn {
            font-family: 'Asap', sans-serif;
            cursor: pointer;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            border: 0;
            border-radius: 5px;
            transition: background-color 300ms;
        }

        .register-btn {
            background-color: rgba(244, 91, 105, 1);
            padding: 10px 20px;
            display: block;
            margin: 20px auto;
        }

        .register-btn:hover {
            background-color: rgba(219, 81, 94, 1);
        }

        .login-btn {
            background-color: #028090;
            text-decoration: none;
            padding: 8px 15px;
            display: block;
            margin: 10px auto;
        }

        .login-btn:hover {
            background-color: #026873;
        }

        @keyframes wawes {
            from {
                transform: rotate(0);
            }
            to {
                transform: rotate(360deg);
            }
        }

        a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            right: 10px;
            bottom: 10px;
            font-size: 12px;
        }
        .cover-image {
            width: 100%;
            height: 400px;
        }
        .cover-image img {
            width: 100%;
            height: 100%;
        }
        .line {
            width: 100%;
            position: absolute;
            height: 50px;
            bottom: 284px
        }
        .line img {
            width: 100%;
            height: 100%;
        }
        .form-title {
            position: absolute;
            left: 50%;
            bottom: 400px;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <div class="form">
                    <form class="login mt-3" action="{{ route('registerUser') }}" method="POST">
                        @csrf

                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif

                        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>

                        <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>

                        <input type="password" name="password" placeholder="Password">
                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>

                        <input type="text" name="code" placeholder="Code" value="{{ old('code') }}">
                        <span class="text-danger">@error('code'){{ $message }}@enderror</span>

                        <button type="submit" class="register-btn">Register</button>
                        <a href="{{ route('storeloginPage') }}" class="login-btn">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>