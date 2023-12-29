<?php

namespace Skillcraft\Core\Providers;

use Botble\Base\Supports\ServiceProvider;
use Skillcraft\Core\PanelSections\CorePanelSection;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\PanelSectionManager;

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
            ->setGroupName(trans('plugins/skillcraft-core::core.group_name'))
            ->register([
                CorePanelSection::class,
            ]);
    }
}
