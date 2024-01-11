<?php

namespace Skillcraft\Core\Forms\FieldOptions;

use Botble\Base\Forms\FieldOptions\NumberFieldOption as CoreNumberFieldOption;

class NumberFieldOption extends CoreNumberFieldOption
{
    public function min(float|int $min): static
    {
        $this->addAttribute('min', $min);

        return $this;
    }

    public function max(float|int $max): static
    {
        $this->addAttribute('max', $max);

        return $this;
    }

    public function step(float|int $step): static
    {
        $this->addAttribute('step', $step);

        return $this;
    }
}
