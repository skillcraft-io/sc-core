<?php

namespace Skillcraft\Core\Abstracts;

use Skillcraft\Core\Models\CoreModel as BaseModel;
use Illuminate\Database\Eloquent\Model;

abstract class HookRegistrarAbstract
{
    private static bool $isPlugin = true;

    private static string $configFile = 'general';

    private static string $supportedKey = 'supported';

    abstract public static function getScreenName():string;

    abstract public static function getModuleName():string;

    public static function isPluginModule():bool
    {
        return static::$isPlugin;
    }

    public static function getConfigFile():string
    {
        return static::$configFile;
    }

    public static function getSupportedKey():string
    {
        return static::$supportedKey;
    }

    public static function getConfigPath(): string
    {
        $module = (static::isPluginModule()) ? 'plugins.' : 'packages.';

        return $module . static::getModuleName().'.'.static::getConfigFile();
    }
    
    public static function getSupportedConfigPath():string
    {
        return static::getConfigPath().'.'.static::getSupportedKey();
    }

    protected static function addMacroHooks():void
    {
        //
    }

    protected static function addFilterHooks():void
    {
        //
    }

    protected static function addActionHooks():void
    {
        //
    }

    protected static function addToModuleRegistrar():void
    {
        //
    }

    public static function load():void
    {
        static::addMacroHooks();
        static::addFilterHooks();
        static::addActionHooks();
        static::addToModuleRegistrar();
    }

    public static function registerHooks(array|string $model, string $name): void
    {
        config([
            static::getSupportedConfigPath() => array_merge(
                static::getSupportedHooks(),
                [$model => $name]
            ),
        ]);
    }

    public static function getSupportedHooks(): mixed
    {
        return apply_filters(
            static::getScreenName(),
            config(static::getSupportedConfigPath(), [])
        );
    }

    /**
     * Checks if the given model is supported.
     *
     * @param BaseModel|Model|string|null $model The model to check.
     * @return bool Returns true if the model is supported, false otherwise.
     */
    public static function isSupported(BaseModel|Model|string|null $model): bool
    {
        if (! $model) {
            return false;
        }

        if (is_object($model)) {
            $model = get_class($model);
        }

        return array_key_exists($model, static::getSupportedHooks());
    }

    /**
     * Retrieves the configurations.
     *
     * @return array.
     */
    public static function getConfigs(): array
    {
        return config(static::getConfigPath(), []);
    }
}
