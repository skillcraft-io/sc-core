<?php

namespace Skillcraft\Core\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static UnitMeasureEnum OUNCE()
 * @method static UnitMeasureEnum GRAM()
 * @method static UnitMeasureEnum LBS()
 * @method static UnitMeasureEnum KILOGRAM()
 * @method static UnitMeasureEnum MILLIGRAM()
 * @method static UnitMeasureEnum EACH()
 */
class UnitMeasureEnum extends Enum
{
    const LBS = 'lbs';
    const OUNCE = 'ounce';
    const GRAM = 'gram';
    const KILOGRAM = 'kilogram';
    const MILLIGRAM = 'milligram';
    const EACH = 'each';

    public static $langPath = 'plugins/skillcraft-core::enums.unit_measures';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            default => parent::toHtml(),
        };
    }
}
