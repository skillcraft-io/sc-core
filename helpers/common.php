<?php

use Skillcraft\Core\Supports\Money\Money;
use Skillcraft\Core\Supports\Money\Currency;

if (!function_exists('sc_core_money')) {
    function sc_core_money(mixed $amount, string $currency = null, bool $convert = null): Money
    {
        if (is_null($currency)) {
            /** @var string $currency */
            $currency = config('plugins.sc-core.money.defaults.currency');
        }

        if (is_null($convert)) {
            /** @var bool $convert */
            $convert = config('plugins.sc-core.money.defaults.convert');
        }

        return new Money($amount, sc_core_currency($currency), $convert);
    }
}

if (!function_exists('sc_core_currency')) {
    function sc_core_currency(string $currency = null): Currency
    {
        if (is_null($currency)) {
            /** @var string $currency */
            $currency = config('plugins.sc-core.money.defaults.currency');
        }

        return new Currency($currency);
    }
}
