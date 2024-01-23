<?php

namespace Skillcraft\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Botble\Base\Supports\ServiceProvider;
use Skillcraft\Core\View\Components\Money;
use Botble\Base\Facades\PanelSectionManager;
use Illuminate\View\Compilers\BladeCompiler;
use Skillcraft\Core\View\Components\Currency;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\CorePanelSection;
use Skillcraft\Core\Supports\Money\Money as MoneySupport;
use Skillcraft\Core\Supports\Money\Currency as CurrencySupport;

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
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews();

        PanelSectionManager::default()
            ->setGroupName(trans('plugins/sc-core::core.group_name'))
            ->register([
                CorePanelSection::class,
            ]);


        MoneySupport::setLocale($this->app->make('translator')->getLocale());

        CurrencySupport::setCurrencies(config('plugins.sc-core.money.currencies', []));

        $this->registerBladeDirectives();
        $this->registerBladeComponents();
    }

    public function registerBladeDirectives(): void
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('sc_core_money', function (?string $expression) {
                return "<?php echo money($expression); ?>";
            });

            $bladeCompiler->directive('sc_core_currency', function (?string $expression) {
                return "<?php echo currency($expression); ?>";
            });
        });
    }

    public function registerBladeComponents(): void
    {
        Blade::component('sc_core_money', Money::class);
        Blade::component('sc_core_currency', Currency::class);
    }
}
