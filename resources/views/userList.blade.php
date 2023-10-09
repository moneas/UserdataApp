@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <h2 class="mt-5">User List</h2>
    
    @if (Auth::check())
        <p class="mt-3">Welcome, {{ Auth::user()->name }}! <a href="{{ route('logout') }}">Logout</a></p>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->date_of_birth }}</td>
                        <td>{{ optional($user->country)->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-3">You are not logged in. <a href="{{ route('register') }}">Register</a></p>
    @endif
@endsection
