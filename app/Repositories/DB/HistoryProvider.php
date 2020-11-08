<?php


namespace App\Repositories\DB;


use App\Models\History;

class HistoryProvider
{
    /**
     * @param string $mobile
     * @param string $ip
     * @return bool
     */
    public function set(string $mobile, string $ip = null)
    {
        return (boolean)History::query()->create([
            "mobile" => $mobile,
            "ip" => $ip,
        ]);
    }
}
