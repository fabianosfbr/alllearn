<?php
namespace App\Services\CoraBank;


class Credentials
{
    public static function getUrl($uri)
    {
        $client_id = config('CORA_BANK_CLIENT_ID');
        $client_secret = config('CORA_BANK_CLIENT_SECRET');

        $env = env('CORA_BANK_ENV');

        $urlBase = $env == 'stage' ? 'https://api.stage.cora.com.br'
                                     : 'https://api.cora.com.br';

        return $urlBase . $uri;
    }
}
