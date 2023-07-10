<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login2(Request $request)
    {

        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['senha'];
        //$email = $request->email;
        //$password = $request->password;

        // Check if field is empty
        if (empty($email) or empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all the fields']);
        }

        $credentials = [
            // 'email' => 'k@k.com',
            // 'password' => '123456'

            'email' => $email,
            'senha' => $password


        ];


        //$credentials = request(['Email', 'Senha']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Check if field is empty
        if (empty($email) || empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all the fields']);
        }

        $credentials = [
            'email' => $email,
            'password' => $password
        ];


        // return response()->json($credentials);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $expiration = 60 * 60; // 1 hour in seconds

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
        ]);
    }

    public function register(Request $request)
    {

        //AINDA TA COMO FORM FILHODAPUTA
        $nomeCompleto = $request->nomeCompleto;
        $DataNasc = $request->DataNasc;
        $CPF = $request->CPF;
        $email = $request->email;
        $password = $request->password;
        $CEP = $request->CEP;
        $Complemento = $request->Complemento;
        $NumeroEndereco = $request->NumeroEndereco;


        // Check if field is empty
        /* if (empty($name) or empty($email) or empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all the fields']);
        }

        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'You must enter a valid email']);
        }

        // Check if password is greater than 5 character
        if (strlen($password) < 6) {
            return response()->json(['status' => 'error', 'message' => 'Password should be min 6 character']);
        }

        // Check if user already exist
        if (User::where('email', '=', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'User already exists with this email']);
        }*/

        // Create new user
        try {
            $user = new User();
      
            $user->nomeCompleto = $request->nomeCompleto;
            $user->DataNasc = $request->DataNasc;
            $user->CPF = $request->CPF;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
            $user->CEP = $request->CEP;
            $user->Complemento = $request->Complemento;
            $user->NumeroEndereco = $request->NumeroEndereco;


            if ($user->save()) {
                return $this->login($request);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}