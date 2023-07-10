<?php
namespace App\Repository;

interface IContaRepository {

    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByUser($userId);
    public function deposito($contaId, $valor);
    public function transferencia($contaId, $valor,$rid);

  


}




?>