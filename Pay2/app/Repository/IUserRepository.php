<?php
namespace App\Repository;

interface IUserRepository {

    public function getAll();
    public function getById($id);
    public function getByEmail($email);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

  


}




?>