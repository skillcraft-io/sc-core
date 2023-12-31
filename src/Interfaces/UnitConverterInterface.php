<?php

namespace Skillcraft\Core\Interfaces;

use Skillcraft\Core\Enums\UnitMeasureEnum;

interface UnitConverterInterface
{
    public function convert(int|float $value, UnitMeasureEnum $fromUnit, UnitMeasureEnum $toUnit): float;
}
