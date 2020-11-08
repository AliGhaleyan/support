<?php

if (!function_exists("set_history")) {
    function set_history(string $mobile, string $ip) {
        return resolve(App\Repositories\DB\HistoryProvider::class)
            ->set($mobile, $ip);
    }
}
