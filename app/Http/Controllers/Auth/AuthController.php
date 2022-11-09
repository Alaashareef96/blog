<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{




    public function editPassword(Request $request){

        return response()->view('cms.auth.edit-password');
    }


    public function editProfile(Request $request){

        return response()->view('cms.auth.edit-profile');
    }




}
