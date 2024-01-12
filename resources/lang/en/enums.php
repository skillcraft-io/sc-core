<?php

use Skillcraft\Core\Enums\SimpleStatusEnum;
use Skillcraft\Core\Enums\UnitMeasureEnum;

return [
    'unit_measures' => [
        UnitMeasureEnum::OUNCE => 'Ounce',
        UnitMeasureEnum::GRAM => 'Gram',
        UnitMeasureEnum::LBS => 'Lbs',
        UnitMeasureEnum::KILOGRAM => 'Kilogram',
        UnitMeasureEnum::MILLIGRAM => 'Milligram',
        UnitMeasureEnum::EACH => 'Each',
    ],
    'simple_status' => [
        SimpleStatusEnum::ACTIVE => 'Active',
        SimpleStatusEnum::INACTIVE => 'Inactive',
    ]
];
