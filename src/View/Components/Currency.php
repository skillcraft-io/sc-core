<?php

namespace Skillcraft\Core\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Currency extends Component
{
    public function __construct(public string $currency)
    {
        //
    }

    /**
     * @psalm-suppress InvalidReturnType,InvalidReturnStatement
     */
    public function render(): View|Factory
    {
        return view('plugins/sc-core::components.currency');
    }
}
