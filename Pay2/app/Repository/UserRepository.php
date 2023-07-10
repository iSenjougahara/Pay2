<?php
namespace App\Repository;

use App\Models\User;

class UserRepository implements IUserRepository{

   
    public function getAll(){
        return User::all()->toJson();
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }
    public function getById($id)
    {
        return User::find($id);
    }
    public function create(array $data)   
    {

        $user = new User($data);


        if ($user->save()) {
            return $user;
        }

    }
    public function update($id, array $data)
    {
        $user = User::find($id);

        if ($user) {
            $user->update($data);
            return true;
        }

        return false;
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
    
        return false;
    }

}
