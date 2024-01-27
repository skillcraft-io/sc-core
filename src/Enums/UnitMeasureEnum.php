<?php

namespace Skillcraft\Core\Enums;

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
    public const LBS = 'lbs';
    public const OUNCE = 'ounce';
    public const GRAM = 'gram';
    public const KILOGRAM = 'kilogram';
    public const MILLIGRAM = 'milligram';
    public const EACH = 'each';

    public static $langPath = 'plugins/sc-core::enums.unit_measures';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            default => parent::toHtml(),
        };
    }
}
