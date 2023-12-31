<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repository\IContaRepository;

class ContaController extends Controller
{
    
    protected $contaRepository;

    public function __construct(IContaRepository $contaRepository)
    {
       
        $this->contaRepository = $contaRepository;
    }

    public function deposito( Request $request)
{
    $validator = Validator::make($request->json()->all(), [
        'valor' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }
    $id = $request->user()->id;
    $valor = $request->json('valor');

    $success = $this->contaRepository->deposito($id, $valor);

    if ($success===true) {
        return response()->json(['message' => 'Deposito created successfully']);
    } else {
        return response()->json(['message' => $success], 422);
    }
}

public function transferencia(Request $request)
{
    $validator = Validator::make($request->json()->all(), [
        'receiver' => 'required',
        'valor' => 'required|numeric',
    ]);
   // return response()->json(['message' => $request->json()], 422);
    if ($validator->fails()) {
        return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }

    $senderId = $request->user()->id;
   // return response()->json(['message' => $senderId], 422);
    $receiverId = $request->json('receiver');
    $valor = $request->json('valor');
    $success = $this->contaRepository->transferencia($senderId, $receiverId, $valor);

    if ($success===true) {
        return response()->json(['message' => 'Transferencia successful']);
    } else {
        return response()->json(['message' => $success], 422);
    }
}

public function getMovimentos(Request $request)
{
    $userId = $request->user()->id;
    $contaId = $this->contaRepository->getContaIdByUserId($userId);
    $movimentos = $this->contaRepository->getMov($contaId);

    return response()->json($movimentos);
}



}
