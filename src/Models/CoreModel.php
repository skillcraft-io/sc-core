<?php

namespace Skillcraft\Core\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Models\BaseQueryBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @method static BaseQueryBuilder<static> query()
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

        if (method_exists(static::class, 'restored')) {
            static::restored(function (CoreModel $model) {
                  do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_RESTORED, $model);
            });
        }

        if (method_exists(static::class, 'forceDeleted')) {
            static::forceDeleted(function (CoreModel $model) {
                do_action(ACTION_HOOK_SKILLCRAFT_CORE_MODEL_AFTER_FORCE_DELETED, $model);
            });
        }
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array<string>
     */
    public function getFillable(): array
    {
        return array_is_list($this->fillable)
            ? $this->fillable
            : array_keys($this->fillable);
    }

    /**
     * Validate the data using fillable rules.
     *
     * @param array|null $data The input data.
     * @param array $rules Any custom rules.
     * @param array $messages Any custom messages.
     * @param array $attributes Any custom attributes.
     * @return self
     * @throws ValidationException
     */
    public function validate(
        array $data = null,
        array $rules = [],
        array $messages = [],
        array $attributes = [],
    ): CoreModel
    {
        $data ??= $this->getAttributes();

        if(! array_is_list($this->fillable)) {
            $rules = array_merge($this->fillable, $rules);
            Validator::make($data, $rules, $messages, $attributes)->validate();
        }

        return $this->fill($data);
    }
}
