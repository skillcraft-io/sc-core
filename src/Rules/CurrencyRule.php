<?php

namespace Skillcraft\Core\Rules;

use Skillcraft\Core\Supports\Money\Currency;
use Illuminate\Contracts\Validation\Rule;

class CurrencyRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return is_string($value) && key_exists(strtoupper($value), Currency::getCurrencies());
    }

    public function message():string
    {
        /** @var string */
        return trans('plugins/sc-core::core.money.invalid-currency');
    }
}
