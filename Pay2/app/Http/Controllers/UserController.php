<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repository\IContaRepository;



class UserController extends Controller
{

    public $user;
    protected $contaRepository;

    public function __construct(IUserRepository $user,IContaRepository $contaRepository)
    {
        $this->user = $user;
        $this->contaRepository = $contaRepository;
    }
    public function getAll()
    {

        return $this->user->getAll();
    }

    public function getById($id)
    {
        return $this->user->getById($id);
    }

    public function getSelf(Request $request)
    {
        return $this->user->getById($request->user()->id);
    }

    public function getConta(Request $request)
    {
        return $this->contaRepository->getByUser($request->user()->id);
    }

    public function getByEmail($email)
    {
        return $this->user->getByEmail($email);
    }

    public function update($id, Request $request)
    {
      
        $validator = Validator::make($request->json()->all(), [
            'nomeCompleto' => 'required',
            'DataNasc' => 'required|date',
            'CPF' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'CEP' => 'required',
            'Complemento' => 'required',
            'NumeroEndereco' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $data = $request->json()->all();

        $data['password'] = Hash::make($data['password']);


        $result = $this->user->update($id, $data);

        if ($result) {
            return response()->json(['message' => 'User updated successfully']);
        }

        return response()->json(['message' => 'Could not update user somehow'], 404);
    
    }

    public function delete($id)
{
    $result = $this->user->delete($id);

    if ($result) {
        return response()->json(['message' => 'User deleted successfully']);
    }

    return response()->json(['message' => 'Could not delete user'], 404);
}


    public function create(Request $request)
    {


     

        $validator = Validator::make($request->json()->all(), [
            'nomeCompleto' => 'required',
            'DataNasc' => 'required|date',
            'CPF' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'CEP' => 'required',
            'Complemento' => 'required',
            'NumeroEndereco' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $data = $request->json()->all();

        $data['password'] = Hash::make($data['password']);

        if ($user = $this->user->create($data)) {
         
            $contaData = [
                'user_id' => $user->id,
            ];
            $conta = $this->contaRepository->create($contaData);
    
            if ($conta) {
                return $this->login($request);
            }
        }
    
        return response()->json(['message' => 'Create failed'], 422);


    }


    public function login(Request $request)
    {


        //return response()->json($request);
        $email = $request->json('email');
        $password = $request->json('password');

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

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
