<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getUserByID($id)
    {
        if (!$user = User::find($id)) {
            throw new \Exception('Пользователя с таким ID не существует');
        }
        return $user;
    }

}