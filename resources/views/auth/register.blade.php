@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-input" 
                       value="{{ old('name') }}" 
                       required>
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-input" 
                       value="{{ old('email') }}" 
                       required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input" 
                       required>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="form-input" 
                       required>
            </div>

            <button type="submit" class="btn-primary w-full">
                Register
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Login disini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection