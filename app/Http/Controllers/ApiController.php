<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Models\User;
use App\Repositories\DB\UserProvider;
use Twom\Responder\Facade\Responder;

class ApiController extends Controller
{
    public function store(CallRequest $request)
    {
        /** @var User|boolean $user */
        $user = $this->getSupportUser();

        set_history($request->phone_number, $request->ip());

        if (!$user)
            // All lines are occupied
            return Responder::respondNotFound();

        $user->update(['busy' => true]);

        return Responder::setRespondData(['support_by' => $user->full_name])
            ->respond();
    }


    protected function getSupportUser()
    {
        /** @var UserProvider $userProvider */
        $userProvider = resolve(UserProvider::class);

        return $userProvider->getOperation() ?:
            $userProvider->getSupervisor() ?:
            $userProvider->getAdmin();
    }
}
