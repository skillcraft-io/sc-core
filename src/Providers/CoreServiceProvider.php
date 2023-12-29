<?php

namespace Skillcraft\Core\Providers;

use Skillcraft\Base\Supports\ServiceProvider;
use Skillcraft\Base\Facades\PanelSectionManager;
use Skillcraft\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\GPTCorePanelSection;

class CoreServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/skillcraft-core')
            ->loadHelpers()
            ->loadAndPublishTranslations();

        PanelSectionManager::default()
            ->setGroupName(trans('Skillcraft Modules'))
            ->register([
                GPTCorePanelSection::class,
            ]);
    }
}
