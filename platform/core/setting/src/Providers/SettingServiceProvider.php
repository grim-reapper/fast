<?php

namespace Fast\Setting\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Setting\Facades\SettingFacade;
use Fast\Setting\Models\Setting as SettingModel;
use Fast\Setting\Repositories\Caches\SettingCacheDecorator;
use Fast\Setting\Repositories\Eloquent\SettingRepository;
use Fast\Setting\Repositories\Interfaces\SettingInterface;
use Fast\Setting\Supports\SettingsManager;
use Fast\Setting\Supports\SettingStore;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * This provider is deferred and should be lazy loaded.
     *
     * @var boolean
     */
    protected $defer = true;

    public function register()
    {
        $this->setNamespace('core/setting')
            ->loadAndPublishConfigurations(['general']);

        $this->app->singleton(SettingsManager::class, function (Application $app) {
            return new SettingsManager($app);
        });

        $this->app->bind(SettingStore::class, function (Application $app) {
            return $app->make(SettingsManager::class)->driver();
        });

        AliasLoader::getInstance()->alias('Setting', SettingFacade::class);

        $this->app->bind(SettingInterface::class, function () {
            return new SettingCacheDecorator(
                new SettingRepository(new SettingModel)
            );
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-settings',
                    'priority'    => 998,
                    'parent_id'   => null,
                    'name'        => 'core/setting::setting.title',
                    'icon'        => 'fa fa-cogs',
                    'url'         => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-general',
                    'priority'    => 1,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'core/base::layouts.setting_general',
                    'icon'        => null,
                    'url'         => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-email',
                    'priority'    => 2,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'core/base::layouts.setting_email',
                    'icon'        => null,
                    'url'         => route('settings.email'),
                    'permissions' => ['settings.email'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-media',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'core/setting::setting.media.title',
                    'icon'        => null,
                    'url'         => route('settings.media'),
                    'permissions' => ['settings.media'],
                ]);
        });
    }

    /**
     * Which IoC bindings the provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SettingsManager::class,
            SettingStore::class,
            'setting',
        ];
    }
}
