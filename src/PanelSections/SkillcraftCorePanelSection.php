<?php

namespace Skillcraft\Core\PanelSections;

use Skillcraft\Base\PanelSections\PanelSection;

class SkillcraftCorePanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('skillcraft.core')
            ->setTitle(trans('Skillcraft Modules'))
            ->withPriority(99998);
    }
}
