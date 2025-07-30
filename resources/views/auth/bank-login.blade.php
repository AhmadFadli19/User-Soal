@extends('layouts.app')

@section('title', 'Bank Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <div class="text-center mb-6">
            <div class="bg-blue-100 rounded-full w-16 h-16 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 00-2-2H8a2 2 0 00-2 2v5m5 0V9a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h3m5-1V2a1 1 0 00-1-1H9a1 1 0 00-1 1v3m5 14h3m-3 0h-3m-3 0H5"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Bank Login</h2>
            <p class="text-gray-600 mt-2">Access Bank Management System</p>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-input" 
                       value="{{ old('email') }}" 
                       placeholder="Enter your bank email"
                       required>
            </div>

            <div class="mb-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input" 
                       placeholder="Enter your password"
                       required>
            </div>

            <button type="submit" class="btn-primary w-full">
                Login to Bank System
            </button>
        </form>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">Demo Bank Accounts:</h3>
            <div class="text-sm text-blue-700 space-y-1">
                <div><strong>Bank Officer:</strong> bank@example.com</div>
                <div><strong>Bank Manager:</strong> manager@example.com</div>
                <div><strong>Password:</strong> password</div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to regular login
            </a>
        </div>
    </div>
</div>
@endsection