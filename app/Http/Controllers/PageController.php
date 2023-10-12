<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;

class PageController extends Controller {

    public function showRegistrationForm() {
        return view( 'auth.register' );
    }

    public function userList() {
        return view( 'userList' );
    }
}
