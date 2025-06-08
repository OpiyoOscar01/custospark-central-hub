<?php

namespace App\Helpers;

use App\Models\Currency;
use App\Services\CurrencyExchangeService;

class CurrencyHelper
{
    public static function convert($amount, $toCurrencyCode, $fromCurrencyCode = 'USD')
    {
        return app(CurrencyExchangeService::class)->convert($amount, $toCurrencyCode, $fromCurrencyCode);
    }

    public static function format($amount, $currencyCode = 'USD')
    {
        $symbol = self::getSymbol($currencyCode);
        return "{$symbol} " .number_format($amount, 2);
    }

    public static function getSymbol($currencyCode)
    {
        return Currency::where('code', $currencyCode)->value('symbol') ?? $currencyCode;
    }

    public static function getActiveCurrencies()
    {
        return Currency::where('is_active', true)->orderBy('name')->get();
    }
}
