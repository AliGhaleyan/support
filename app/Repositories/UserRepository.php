<?php


namespace App\Repositories;


class UserRepository
{
    const OPERATOR_TPE = "operator";
    const SUPERVISOR_TPE = "supervisor";
    const ADMIN_TPE = "admin";


    public static function usersTypes()
    {
        return [
            static::OPERATOR_TPE,
            static::SUPERVISOR_TPE,
            static::ADMIN_TPE,
        ];
    }
}
