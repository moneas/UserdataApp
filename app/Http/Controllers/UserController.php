<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Country;
use Illuminate\Validation\Rule;
use Laravel\Passport\Token;

class UserController extends Controller {

    public function index( Request $request ) {
        $query = User::with( 'country' );

        if ( $request->has( 'name' ) ) {
            $query->where( 'name', 'like', '%' . $request->input( 'name' ) . '%' );
        }

        if ( $request->has( 'country_id' ) ) {
            $query->where( 'country_id', $request->input( 'country_id' ) );
        }

        $users = $query->get();

        return response()->json( [ 'users' => $users ] );
    }

    public function countryList() {
        $countries = Country::all();
        return response()->json( [ 'countries' => $countries ] );
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

            $token = $user->createToken( 'AuthToken' )->accessToken;

            Auth::login( $user );

            return response()->json( [ 'status' => 'success', 'message' => 'Registration successful', 'token' => $token ], 200 );
        } catch ( \Exception $e ) {
            if ( strpos( $e->getMessage(), 'Duplicate entry' ) !== false ) {
                return response()->json( [ 'status' => 'error', 'message' => 'Email address already exists.' ], 422 );
            } else {
                return response()->json( [ 'status' => 'error', 'message' => 'Registration failed.' ], 403 );
            }
        }
    }

    public function userList() {
        if ( Auth::check() ) {
            $users = User::with( 'country' )->get();
            return response()->json( [ 'users' => $users ] );
        } else {
            return response()->json( [ 'error' => 'Unauthorized' ], 401 );
        }
    }

    public function logout() {
        $accessToken = Auth::user()->token();
        Token::where( 'id', $accessToken->id )->update( [ 'revoked' => true ] );
        return response()->json( [ 'message' => 'Logged out successfully' ] );
    }
}
