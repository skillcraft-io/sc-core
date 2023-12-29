<?php

namespace Skillcraft\Core;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('pages_translations');
        Schema::dropIfExists('slugs_translations');
    }
}
