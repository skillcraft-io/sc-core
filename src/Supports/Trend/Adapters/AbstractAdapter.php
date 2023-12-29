<?php

namespace Skillcraft\Core\Supports\Trend\Adapters;

abstract class AbstractAdapter
{
    abstract public function format(string $column, string $interval): string;
}
