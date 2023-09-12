<?php

namespace App\Services\AbuseDetection;

use Exception;
use Illuminate\Support\Facades\Http;

class Komprehend implements AbuseDetector
{
    private const ENDPOINT = 'https://apis.paralleldots.com/v4/abuse';

    public function __construct(
        public string $token
    ) {
    }

    public function check(string $text): bool
    {
        $response = Http::asForm()
            ->post(self::ENDPOINT, [
                'text' => $text,
                'api_key' => $this->token,
            ])
            ->json();

        if ($response['code'] !== 200) {
            throw new Exception('Komprehend failed to response.');
        }

        return $response['abusive'] > 0.7 || $response['hate_speech'] > 0.7;
    }
}
