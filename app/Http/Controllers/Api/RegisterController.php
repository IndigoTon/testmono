<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);
            $success['token'] = $user->createToken('TaskMono')->accessToken;
            $success['name'] = $user->name;
            DB::commit();
            return $this->sendResponse($success, 'Registration user success!');
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }
}
