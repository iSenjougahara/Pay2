<?php

namespace App\Repository;
use App\Models\Movimento;
use App\Models\Conta;

class ContaRepository implements IContaRepository
{
    public function getAll()
    {
        return Conta::all();
    }

    public function getById($id)
    {
        return Conta::find($id);
    }

    public function getByUser($userId)
    {
        return Conta::where('user_id', $userId)->get();
    }


    public function create(array $data)
    {
        $conta = new Conta($data);

        if ($conta->save()) {
            return $conta;
        }

        return false;
    }


    public function update($id, array $data)
    {
        $conta = Conta::find($id);

        if ($conta) {
            $conta->update($data);
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $conta = Conta::find($id);

        if ($conta) {
            $conta->delete();
            return true;
        }

        return false;
    }
/*
    public function deposit($contaId, $amount)
{
    $conta = Conta::find($contaId);

    if ($conta) {
        $conta->saldo += $amount;
        $conta->save();
        return true;
    }

    return false;
}
*/
public function deposito($id, $valor)
{
    $conta = Conta::find($id);
    
    if (!$conta) {
        return "Conta not found"; // Conta not found
    }

    // Update saldo
    $conta->saldo += $valor;
    $conta->save();

    //$mm=;

    //return $mm;
    // Create a new deposito movimento
    $movimento = new Movimento([
        'valor' => $valor,
        'conta_id' => $conta->id,
        
    ]);
    $movimento->save();
    $movimento->code = 'DEP' . str_pad($movimento->id, 4, '0', STR_PAD_LEFT);
    $movimento->save();

    

    return true; 
}

public function transferencia($senderId, $receiverId, $valor)
{
    $senderConta = Conta::find($senderId);
    $receiverConta = Conta::find($receiverId);

    if (!$senderConta || !$receiverConta) {
        return "Conta not found";
    }

    // Check if sender has sufficient saldo
    if ($senderConta->saldo < $valor) {
        return "Not enough money";
    }

    // Update saldo for sender and receiver
    $senderConta->saldo -= $valor;
    $receiverConta->saldo += $valor;
    $senderConta->save();
    $receiverConta->save();

    // Create a new transferencia movimento for sender
    $senderMovimento = new Movimento([
        'valor' => $valor,
        'conta_id' => $senderConta->id,
        'receiver' => $receiverConta->id,
    ]);
    $senderMovimento->save(); // Save the movimento first to assign an ID
    $senderMovimento->code = 'TRANSF' . str_pad($senderMovimento->id, 4, '0', STR_PAD_LEFT);
    $senderMovimento->save(); // Update the movimento with the correct code

    return true;
}





}
