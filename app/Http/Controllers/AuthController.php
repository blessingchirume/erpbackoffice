<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/auth",
     *      
     *      tags={"Auth"},
     *      summary="Authenticates user",
     *      description="Returns authenticated user",
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="email"
     *          )
     *      ),
     * 
     *      @OA\Response(
     *          response=200,
     *          description="{}"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     */

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(["error" => null, "error" => "Unauthenticated"], 400);
        }

        $user = User::where('email', Auth::user()->email)->first();
        $token = 'Bearer ' . $user->createToken('erpbackoffice')->accessToken;

        return response()->json(["success" => ["userData" => $user, "token" => $token], "error" => null]);
    }

    public function profile()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'surname' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);
        try {
            User::find(Auth::user()->id)->update($data);
            return response()->json(['success' => 'user has been updated!', 'error' => null]);
        } catch (\Throwable $th) {
            return response()->json(['success' => null, 'error' => $th->getMessage()]);
        }
    }

    public function delete()
    {
        try {
            User::find(Auth::user()->id)->delete();
            return response("User account deleted successfully");
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function logout()
    {
        # code...
    }

    public function passwordReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT)
        {
            return[
                "status" => __($status)
            ];
        }

        throw ValidationException::withMessages(
            ["email" => [trans($status)]]
        );

        // try {
        //     User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        //     return response()->json(['success' => 'user has been updated!', 'error' => null]);
        // } catch (\Throwable $th) {
        //     return response()->json(['success' => null, 'error' => $th->getMessage()]);
        // }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $data['password'] = Hash::make($request->password);
        try {
            User::create($data);
            return response()->json(['success' => 'user has been created!', 'error' => null]);
        } catch (\Throwable $th) {
            return response()->json(['success' => null, 'error' => $th->getMessage()]);
        }
    }

    public function forgot_password(Request $request)
    {
        // $input = $request->all();
        // $rules = array(
        //     'email' => "required|email",
        // );
        // $validator = Validator::make($input, $rules);
        // if ($validator->fails()) {
        //     $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        // } else {
        //     try {
        //         $response = Password::sendResetLink($request->only('email'), function (Message $message) {
        //             $message->subject($this->getEmailSubject());
        //         });
        //         switch ($response) {
        //             case Password::RESET_LINK_SENT:
        //                 return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
        //             case Password::INVALID_USER:
        //                 return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
        //         }
        //     } catch (\Swift_TransportException $ex) {
        //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        //     } catch (Exception $ex) {
        //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        //     }
        // }
        // return \Response::json($arr);
    }
}
