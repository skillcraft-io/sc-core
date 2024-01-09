<?php

namespace Skillcraft\Core\Models;

use Botble\Base\Models\BaseModel;

/**
 * @method static \Skillcraft\Base\Models\BaseQueryBuilder<static> query()
 */
class CoreModel extends BaseModel
{
    //
    protected static function booted()
    {
        parent::booted();

        static::created(function (CoreModel $model) {
            do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_CREATED, $model);
        });

        static::updated(function (CoreModel $model) {
            do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_UPDATED, $model);
        });

        static::deleted(function (CoreModel $model) {
            do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_DELETED, $model);
        });

        static::restored(function (CoreModel $model) {
            do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_RESTORED, $model);
        });

        static::forceDeleted(function (CoreModel $model) {
            do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_FORCE_DELETED, $model);
        });
    }
}
