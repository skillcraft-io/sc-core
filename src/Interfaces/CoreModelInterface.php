<?php

namespace Skillcraft\Core\Interfaces;

interface CoreModelInterface
{
    /**
     * Define the model schema on fresh install
     *
     * @return void
     */
    public function modelInstallSchema(): void;
}
