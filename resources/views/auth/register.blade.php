@extends('layouts.app')

@section('title', 'User Registration')

@section('content')
    <h2 class="mt-5">User Registration</h2>
    
    @if (Auth::check())
        <p class="mt-3">You are already registered. <a href="{{ route('user.list') }}">Go to User List</a></p>
    @else
        <form action="{{ route('register') }}" method="POST" id="registration-form">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="country_id">Country:</label>
                <select class="form-control" name="country_id" id="country_id" required>
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="registration-messages" class="mt-3"></div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    @endif

    <script src="{{ asset('js/register.js') }}"></script>
@endsection
