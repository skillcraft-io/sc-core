<?php

namespace Skillcraft\Core\Traits;

trait FillableValidation
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootFillableValidation()
    {
        static::saving(fn ($model) => $model->validate());
    }
}
