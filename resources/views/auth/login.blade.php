<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{asset('images/mi.png')}}">

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            padding: 0;
        }

        .login-container, .logo-container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 80px;
        }

        .login-container {
            background-color: #006600;
            color: #fff;
            flex: 1;
            align-items: flex-start;
            
        }

        .logo-container {
            background-color: #fff;
            color: #333;
            flex: 1.2;
            text-align: center;
        }

        .login-container p, .login-container label {
            width: 100%;
        }

        .form-group input {
            margin-bottom: 20px;
            padding: 15px;
            border: 2px solid #ffffff;
            border-radius: 20px;
            width: 100%;
            color: white;
            font-size: 18px;
            background-color: #006600; 
        }

        .custom-checkbox {
            display: flex;
            align-items: stretch;
            margin-bottom: 10px;
        }

        .form-group button {
            padding: 10px;
            background-color: #ea7f03;
            border: none;
            border-radius: 25px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            width: 50%;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 40px;
        }
        .password-container .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            cursor: pointer;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column;
            }

            .login-container, .logo-container {
                width: 100%;
                height: 50vh;
                padding: 20px;
            }

            .login-container {
                align-items: center;
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="logo-container">
            <img src="{{ asset('images/kto_logo.png') }}" alt="Logo" class="img-fluid animate__animated w-[550px] animate__fadeInUp" style="max-width: 550px;animation-duration: 2s;">
        </div>
        <div class="login-container" style="background-color: #9e9ea1;">
            <h1 class="text-4xl font-jakarta font-bold mb-14 mt-6 ml-14">Welcome !</h1>
            <form method="POST" action="{{ route('login') }}" autocomplete="off" class="ml-14" onsubmit="storePassword(event)">
                @csrf
                
                <div class="form-group">
                    <label for="username" class="font-jakarta font-bold">Username</label>
                    <input type="name" name="name" class="form-control mt-4 animate__animated animate__flipInX" style="background-color: #9e9ea1;" id="name" required>
                </div>

                <div class="form-group password-container">
                    <label for="password" class="font-jakarta font-bold">Password</label>
                    <input type="password" name="password" class="form-control mt-4 animate__animated animate__flipInX" id="password" style="background-color: #9e9ea1;" required>
                    <span class="fa-regular fa-eye-slash cursor-pointer toggle-password" id="eyeicon" onclick="togglePassword()" ></span>
                </div>
                
                <div class="custom-checkbox">
                    <input type="checkbox" class="animate__animated animate__flipInX" name="remember" id="remember">
                    <label class="font-jakarta ml-3">Remember me</label>
                </div>

                <!-- Error Message -->
                @error('name')
                    <p class="text-md mb-3" style="color: white;font-weight:bolder">* {{ $message }}</p>
                @enderror
                <div class="form-group flex">
                    <button type="submit" class="text-xl font-poppins ml-auto mx-auto animate__animated animate__flipInX">Log In</button>
                </div>
                
            </form>
        </div>
        
    </div>
</body>
<script src="{{ asset('js/fontawesome.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/crypto-js@4.1.1/crypto-js.min.js"></script>
<script>
    function togglePassword() {
        var myInput = document.getElementById("password");
        var eyeicon = document.getElementById("eyeicon");

        if (myInput.type === "password") {
            myInput.type = "text";
            eyeicon.classList.remove("fa-eye-slash");
            eyeicon.classList.add("fa-eye");

        } else {
            myInput.type = "password";
            eyeicon.classList.remove("fa-eye");
            eyeicon.classList.add("fa-eye-slash");
        }
    }
</script>

<script>
    function storePassword(event) {
        event.preventDefault();
        var nameInput = document.getElementById('name');
        var passwordInput = document.getElementById('password');
        var remember = document.getElementById('remember').checked;

        if (remember) {
            localStorage.setItem('rememberedName', CryptoJS.AES.encrypt(nameInput.value, 'secret-key').toString());
            localStorage.setItem('rememberedPassword', CryptoJS.AES.encrypt(passwordInput.value, 'secret-key').toString());
        } else {
            localStorage.removeItem('rememberedName');
            localStorage.removeItem('rememberedPassword');
        }

        event.target.submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var rememberedName = localStorage.getItem('rememberedName');
        var rememberedPassword = localStorage.getItem('rememberedPassword');

        if (rememberedName && rememberedPassword) {
            document.getElementById('name').value = CryptoJS.AES.decrypt(rememberedName, 'secret-key').toString(CryptoJS.enc.Utf8);
            document.getElementById('password').value = CryptoJS.AES.decrypt(rememberedPassword, 'secret-key').toString(CryptoJS.enc.Utf8);
            document.getElementById('remember').checked = true;
        }
    });
</script>
</html>
