<?php


namespace App\Repositories\DB;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserProvider
{
    public function getOperation()
    {
        return $this->getUserByType(UserRepository::OPERATOR_TPE);
    }


    public function getSupervisor()
    {
        return $this->getUserByType(UserRepository::SUPERVISOR_TPE);
    }


    public function getAdmin()
    {
        return $this->getUserByType(UserRepository::ADMIN_TPE);
    }


    /**
     * @param string $type
     * @return Builder|Model|object|null
     */
    public function getUserByType(string $type)
    {
        return User::query()
                ->where("type", $type)
                ->where("busy", false)
                ->first() ?? false;
    }
}
