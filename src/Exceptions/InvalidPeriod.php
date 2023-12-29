<?php

namespace Skillcraft\Core\Exceptions;

use DateTimeInterface;
use Exception;

class InvalidPeriod extends Exception
{
    public static function startDateCannotBeAfterEndDate(
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ): self {
        return new self(
            trans('plugins/skillcraft-core::core.start_date_can_not_before_end_date', [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ])
        );
    }
}
