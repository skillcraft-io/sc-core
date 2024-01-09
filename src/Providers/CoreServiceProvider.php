<?php

namespace Skillcraft\Core\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\CorePanelSection;

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
