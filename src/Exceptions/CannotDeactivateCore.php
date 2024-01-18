<?php

namespace Skillcraft\Core\Exceptions;

use DateTimeInterface;
use Exception;

class CannotDeactivateCore extends Exception
{
    public static function dependentPluginsActive(): self
    {
        return new self(
            trans('plugins/sc-core::core.dependent_plugins_active')
        );
    }
}
