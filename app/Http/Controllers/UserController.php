<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Country;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    public function showRegistrationForm() {
        if ( Auth::check() ) {
            // return redirect()->route( 'user.list' );
        }
        $countries = Country::all();
        return view( 'auth.register', compact( 'countries' ) );
    }

    public function store( Request $request ) {
        $request->validate( [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique( 'users' ), // Ensure email uniqueness in the 'users' table
            ],
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'country_id' => 'required|exists:countries,id',
        ] );

        try {
            $user = User::create( [
                'name' => $request->input( 'name' ),
                'email' => $request->input( 'email' ),
                'password' => bcrypt( $request->input( 'password' ) ),
                'date_of_birth' => $request->input( 'date_of_birth' ),
                'country_id' => $request->input( 'country_id' ),
            ] );

            Auth::login( $user );
            return response()->json( [ 'status' => 'success', 'message' => 'Registration successful' ], 200 );
        } catch ( \Exception $e ) {
            if ( strpos( $e->getMessage(), 'Duplicate entry' ) !== false ) {
                return response()->json( [ 'status' => 'error', 'message' => 'Email address already exists.' ], 422 );
            } else {
                return response()->json( [ 'status' => 'error', 'message' => 'Registration failed.' ], 403 );
            }
        }
    }

    public function userList() {
       // $users = User::all( [ 'id', 'name', 'email', 'date_of_birth', 'country_id' ] );
        $users = User::with('country')->get();
        return view( 'userList', compact( 'users' ) );
    }

    public function logout() {
        Auth::logout();
        return redirect()->route( 'register' );
        // Redirect to the registration page after logout
    }

}
