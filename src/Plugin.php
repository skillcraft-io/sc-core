<?php

namespace Skillcraft\Core;

use Illuminate\Support\Str;
use Skillcraft\Core\Exceptions\CannotDeactivateCore;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function deactivate()
    {
        foreach (get_active_plugins() as $plugin) {
            if (Str::contains($plugin, 'sc-') && $plugin !== 'sc-core') {
                throw CannotDeactivateCore::dependentPluginsActive();
            }
        }
    }
}
