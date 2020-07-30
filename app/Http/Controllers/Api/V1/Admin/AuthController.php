<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{

    use GeneralTrait;
    public function login(Request $request)
    {

        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

             $credentials = $request -> only(['email','password']) ;

             $token =  Auth::guard('admin-api') -> attempt($credentials);

           if(!$token)
               return $this->returnError('E001','There Are Not Valid Data !');

             $admin = Auth::guard('admin-api') -> user();
             $admin -> api_token = $token;
            //return token
             return $this -> returnData('admin' , $admin);

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }
}
