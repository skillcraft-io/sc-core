<?php

namespace Skillcraft\Core\Providers;

use Botble\Base\Supports\ServiceProvider;
use Skillcraft\Core\Supports\MetaBusiness;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\CorePanelSection;
use Skillcraft\Core\Abstracts\MetaBusinessApiAbstract;
use Skillcraft\Core\Exceptions\InvalidFacebookConfiguration;
use Skillcraft\Core\Contracts\MetaBusinessApiCredentialsContract;

class CoreServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(MetaBusinessApiAbstract::class, function () {
            $credentials = new MetaBusinessApiCredentialsContract(
                setting('facebook_app_id'),
                setting('facebook_app_secret'),
                setting('facebook_page_id'),
                setting('facebook_page_access_token'),
            );

            if (!$credentials->validateParams()) {
                throw InvalidFacebookConfiguration::credentialsIsNotValid();
            }

            return (new MetaBusiness($credentials))->getClient();
        });
    }

    public function boot(): void
    {
        if (true) {
            require __DIR__ . '/../../vendor/autoload.php';
        }

        $this
        ->setNamespace('plugins/skillcraft-core')
        ->loadHelpers()
        ->loadAndPublishTranslations()
        ->loadAndPublishConfigurations(['general']);

        PanelSectionManager::default()
        ->setGroupName(trans('plugins/skillcraft-core::core.group_name'))
        ->register([
            CorePanelSection::class,
        ]);
    }
}
