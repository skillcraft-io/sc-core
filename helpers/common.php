<?php

use Botble\Base\Facades\BaseHelper;
use Composer\Autoload\ClassLoader;

if (!function_exists('getPluginModels')) {
    function getPluginModels(string $plugin):array
    {
        $modelDirectoryPath = plugin_path($plugin . '/src/Models');

        $jsonFilePath = plugin_path($plugin . '/plugin.json');

        $content = BaseHelper::getFileData($jsonFilePath);

        if (! class_exists($content['provider'])) {
            $loader = new ClassLoader();
            $loader->setPsr4(
                $content['namespace'],
                plugin_path($plugin . '/src')
            );
            $loader->register(true);

           app()->register($content['provider']);
        }

        $pluginModels = [];

        $files = BaseHelper::scanFolder($modelDirectoryPath);
    
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {

                $className = basename($file);

                $fullClassName = $content['namespace'] . 'Models\\' . $className;
                
                $pluginModels[] = $fullClassName;
            }
        }

        return $pluginModels;
    }
}
