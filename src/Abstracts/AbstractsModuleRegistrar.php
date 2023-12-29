<?php

namespace Skillcraft\Core\Abstracts;

use Skillcraft\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractsModuleRegistrar
{
    private static bool $isPlugin = true;

    private static string $configFile = 'general';

    private static string $supportedKey = 'supported';

    abstract public static function getScreenName():string;

    abstract public static function getModuleName():string;

    public static function isPluginModule():bool
    {
        return self::$isPlugin;
    }

    public static function getConfigFile():string
    {
        return self::$configFile;
    }

    public static function getSupportedKey():string
    {
        return self::$supportedKey;
    }

    public static function getConfigPath(): string
    {
        return (self::isPluginModule()) ? 'plugins.' : 'packages.'. self::getModuleName().'.'.self::getConfigFile();
    }
    
    public static function getSupportedConfigPath():string
    {
        return self::getConfigPath().'.'.self::getSupportedKey();
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
        self::addMacroHooks();
        self::addFilterHooks();
        self::addActionHooks();
        self::addToModuleRegistrar();
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

        return in_array($model, self::getSupportedHooks());
    }

    /**
     * Retrieves the configurations for the GPT Wallet plugin.
     *
     * @return array The configurations for the GPT Wallet plugin.
     */
    public static function getConfigs(): array
    {
        return config(self::getConfigPath(), []);
    }
}
