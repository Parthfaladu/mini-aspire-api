<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{RegisterRequest, LoginRequest};
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * admin registration
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function adminRegister(RegisterRequest $request)
    {
        $token = $this->register($request, true);

        return response()->json($token)->setStatusCode(201);
    }

    /**
     * customer registration
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function customerRegister(RegisterRequest $request)
    {
        $token = $this->register($request);

        return response()->json($token)->setStatusCode(201);
    }

    /**
     * admin and customer registration
     *
     * @param [type] $request
     * @param boolean $isAdmin
     * @return void
     */
    private function register($request, $isAdmin = false)
    {
        $user = new User;
        $user->name     = $request->get("name");
        $user->email    = $request->get("email");
        $user->password = bcrypt($request->get("password"));
        $user->is_admin = $isAdmin;
        $user->save();

        return $user->createToken('aspire-token');
    }

    /**
     * admin and customer login
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $user = User::where("email", $request->get("email"))->first();

        if($user && Hash::check($request->get("password"), $user->password)) {
            $token = $user->createToken('aspire-token');

            return response()->json($token);
        }
        return response()->json(["status" => "failed", "message" => "Invalid email address or password."])->setStatusCode(400);
    }
}
