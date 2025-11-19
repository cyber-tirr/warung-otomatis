@extends('layouts.app')

@section('title', 'Login - Warung Kopi Otomatis')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    }
    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
        position: relative;
    }
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #c9a961, #d4b574);
    }
    .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #c9a961;
        box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
    }
    .btn-primary {
        background: linear-gradient(135deg, #c9a961, #d4b574);
        border: none;
        color: #1a1a1a;
        font-weight: 700;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #d4b574, #c9a961);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(201, 169, 97, 0.3);
        color: #000000;
    }
</style>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card login-card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div style="background: linear-gradient(135deg, #c9a961, #d4b574); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="bi bi-cup-hot-fill" style="font-size: 2.5rem; color: #1a1a1a;"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #1a1a1a;">Warung Kopi Otomatis</h3>
                        <p class="text-muted">Login Admin/Operator</p>
                        <div style="width: 60px; height: 3px; background: linear-gradient(90deg, #c9a961, #d4b574); margin: 15px auto;"></div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
