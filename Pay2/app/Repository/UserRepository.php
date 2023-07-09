<?php
namespace App\Repository;

use App\Models\User;

class UserRepository implements IUserRepository{

   
    public function getAll(){
        return User::all()->toJson();
    }


}




?>