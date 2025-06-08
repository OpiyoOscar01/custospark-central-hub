<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyExchangeService
{
    public function convert($amount, $toCurrency, $fromCurrency = 'USD')
    {
        if ($toCurrency === $fromCurrency) {
            return $amount;
        }

        $rate = $this->getExchangeRate($fromCurrency, $toCurrency);

        return $rate ? round($amount * $rate, 2) : null;
    }

    public function getExchangeRate($from, $to)
    {
        $cacheKey = "exchange_rate_{$from}_{$to}";

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($from, $to) {
            $url = config('services.exchange_rate.base_url') . '/' . config('services.exchange_rate.key') . "/pair/{$from}/{$to}";

            $response = Http::get($url);

            if ($response->successful() && isset($response['conversion_rate'])) {
                return $response['conversion_rate'];
            }

            return null;
        });
    }
}

