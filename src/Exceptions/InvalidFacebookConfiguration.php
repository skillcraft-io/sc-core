<?php

namespace Skillcraft\Core\Exceptions;

use Botble\Base\Facades\Html;
use Exception;

class InvalidFacebookConfiguration extends Exception
{
    public static function credentialsIsNotValid(): self
    {
        return new self(trans('plugins/sc-core::core.settings.credential_is_not_valid', [
            'url' => Html::link('https://docs.botble.com/cms/usage-analytics.html',
            attributes: ['target' => '_blank']
        )->toHtml()]));
    }

    public static function invalidPropertyId(): self
    {
        return new self(trans('plugins/sc-core::core.settings.property_id_is_invalid'));
    }
}
