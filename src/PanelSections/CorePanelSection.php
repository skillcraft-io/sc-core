<?php

namespace Skillcraft\Core\PanelSections;

use Botble\Base\PanelSections\PanelSection;

class CorePanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('skillcraft.panelsection.core')
            ->setTitle(trans('plugins/skillcraft-core::core.panelsection_title'))
            ->withPriority(99998);
    }
}
