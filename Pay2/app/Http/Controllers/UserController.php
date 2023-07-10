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
        // $data = $request->all();

        // Hash the password if it is provided in the request

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










    /* public function store(Request $request)
    {
        try {
            $user = new User();
            $data = $request->json()->all();
            $user->nomeCompleto = $data['nomeCompleto'];
            $user->DataNasc = $data['DataNasc'];
            $user->CPF = $data['CPF'];
            //$user->Email = $data['Email'];
            $user->email = $data['email'];
            $user->password = app('hash')->make($data['password']);
            //$user->Senha = $data['Senha'];
           // $user->Senha = app('hash')->make($data['Senha']);
            
            $user->CEP = $data['CEP'];
            $user->Complemento = $data['Complemento'];
            $user->NumeroEndereco = $data['NumeroEndereco'];
            

            if ($user->save()) {
                return response()->json(['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } */

    public function create(Request $request)
    {


        //lembra q senha agora é passowrd
        /*   $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'DataNasc' => 'required|date',
            'CPF' => 'required',
            'Email' => 'required|email',
            'Senha' => 'required',
            'CEP' => 'required',
            'Complemento' => 'nullable',
            'NumeroEndereco' => 'required',
        ]);*/

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
        //return $data;
        // $data = $request->all();

        // Hash the password before creating the user
        $data['password'] = Hash::make($data['password']);

        // Create the user using the repository
       /* if ($this->user->create($data)) {
            return $this->login($request);
        } else {
            return response()->json(['message' => 'Create failed'], 422);


        }*/
       


        if ($user = $this->user->create($data)) {
            // Create a new conta for the user
            $contaData = [
                'user_id' => $user->id,
            ];
            $conta = $this->contaRepository->create($contaData);
    
            if ($conta) {
                return $this->login($request);
            }
        }
    
        return response()->json(['message' => 'Create failed'], 422);

        //do the trycatch



        // return response()->json(['message' => 'User created successfully', 'user' => $user], 201);


    }


    public function login(Request $request)
    {

        //$email = $request->email;
        //$password = $request->password;
        $email = $request->json('email');
        $password = $request->json('password');


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
}
