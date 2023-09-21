@extends('layouts.frontend')

@section('content')
<style>
    .login-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 400px;
        margin: 30px auto;
    }

    .login-container h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .floating-label-group {
        position: relative;
        margin-bottom: 20px;
    }

    .floating-label-group input {
        width: 100%;
        padding: 10px 10px 10px 0;
        border: none;
        border-bottom: 2px solid #ddd;
        background: transparent;
        font-size: 16px;
        outline: none;
    }

    .floating-label-group label {
        position: absolute;
        top: 10px;
        left: 0;
        font-size: 16px;
        color: #999;
        transition: 0.3s;
        pointer-events: none;
    }

    .floating-label-group input:focus+label,
    .floating-label-group input:not(:placeholder-shown)+label {
        top: -5px;
        font-size: 12px;
        color: #007BFF;
    }

    .login-button {
        width: 100%;
        padding: 10px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: #ff0000;
        margin-bottom: 10px;
        text-align: center;
    }

    .password-recovery {
        text-align: center;
        margin-top: 20px;
    }

    /* Larger screen adjustments */
    @media (min-width: 768px) {
        .login-container {
            padding: 40px;
        }
    }
</style>
<div class="login-container">
    <h1>Login</h1>
    <div class="error-message" id="error-message">
        @include('layouts.partials.messages')
    </div>

    <form action="{{ route('login.perform') }}" method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="floating-label-group">
            <input type="email" id="username" name="username" required placeholder=" " value="{{ old('username') }}" autofocus>
            <label for="email">Email</label>
        </div>
        <div class="floating-label-group">
            <input type="password" id="password" name="password" required placeholder=" " value="{{ old('password') }}">
            <label for="password">Password</label>
        </div>
        <button class="login-button" type="submit">Login</button>

    </form>
</div>

<script>
    function validateForm() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('error-message');

        // Basic validation (you'd typically handle this server-side and send back appropriate messages)
        if (!email.includes("@")) {
            errorMessage.textContent = "Invalid email address.";
            return false;
        }
        if (password.length < 6) {
            errorMessage.textContent = "Password must be at least 6 characters.";
            return false;
        }
        return true;
    }
</script>

@endsection