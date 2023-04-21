<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CrudRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail($email)
    {
        return $this->getQuery()->where("email", $email)->firstOrFail();
    }
}
