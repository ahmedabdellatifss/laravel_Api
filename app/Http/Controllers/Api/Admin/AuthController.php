<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        // Validation
        try{
            $rules = [
                "password"=>"required",
                "email"=> "required|exists:admins,email",
            ];
            $validator = Validator::make($request->all() , $rules);

            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code , $validator);
            }
        // login

        //return
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode() , $ex->getMessage());
        }
    }
}
