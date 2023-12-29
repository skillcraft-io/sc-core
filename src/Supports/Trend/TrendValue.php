<?php

namespace Skillcraft\Core\Supports\Trend;

class TrendValue
{
    public function __construct(
        public string $date,
        public mixed $aggregate,
    ) {
    }
}
