<?php

namespace Skillcraft\Core\Providers;

use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\CorePanelSection;

class CoreServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        if (is_plugin_active('skillcraft-core')) {
            return;
        }

        $this
            ->setNamespace('plugins/sc-core')
            ->loadHelpers()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['general']);

        PanelSectionManager::default()
            ->setGroupName(trans('plugins/sc-core::core.group_name'))
            ->register([
                CorePanelSection::class,
            ]);
    }
}
