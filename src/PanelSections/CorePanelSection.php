<?php

namespace Skillcraft\Core\PanelSections;

use Botble\Base\PanelSections\PanelSection;

class CorePanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId(SKILLCRAFT_CORE_PANELSECTION_NAME)
            ->setTitle(trans('plugins/skillcraft-core::core.panelsection_title'))
            ->withPriority(99999);
    }
}
