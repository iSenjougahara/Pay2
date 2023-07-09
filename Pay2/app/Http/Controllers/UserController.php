<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public $user;

    public function __construct(IUserRepository $user) {
        $this->user = $user;
    }
    public function getAll()
    {

        return $this->user->getAll(); 
    }





    public function create(Request $request)
    {



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

       /* $validator = Validator::make($request->json()->all(), [
            'nomeCompleto' => 'required',
            'DataNasc' => 'required|date',
            'CPF' => 'required',
            'Email' => 'required|email',
            'Senha' => 'required',
            'CEP' => 'required',
            'Complemento' => 'nullable',
            'NumeroEndereco' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        } */
        $data = $request->json()->all();
        // $data = $request->all();

        // Hash the password before creating the user
        $data['Senha'] = Hash::make($data['Senha']);

        // Create the user using the repository
       
      //  $user = $this->user->create($data);
      $user =User::create($data);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function store(Request $request)
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
    }
}   


