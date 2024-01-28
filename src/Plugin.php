<?php

namespace Skillcraft\Core;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Str;
use Skillcraft\Core\Exceptions\CannotDeactivateCore;

class Plugin extends PluginOperationAbstract
{
    public static function deactivate(): void
    {
        foreach (get_active_plugins() as $plugin) {
            if (Str::contains($plugin, 'sc-') && $plugin !== 'sc-core') {
                throw CannotDeactivateCore::dependentPluginsActive();
            }
        }
    }
}
