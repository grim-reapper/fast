<?php

namespace Fast\CustomField\Providers;

use Fast\ACL\Repositories\Interfaces\RoleInterface;
use Fast\ACL\Repositories\Interfaces\UserInterface;
use Fast\Base\Events\SessionStarted;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\CustomField\Facades\CustomFieldSupportFacade;
use Fast\Page\Repositories\Interfaces\PageInterface;
use Fast\Support\Services\Cache\Cache;
use Fast\Base\Supports\Helper;
use Fast\CustomField\Models\CustomField;
use Fast\CustomField\Models\FieldGroup;
use Fast\CustomField\Models\FieldItem;
use Fast\CustomField\Repositories\Caches\CustomFieldCacheDecorator;
use Fast\CustomField\Repositories\Eloquent\CustomFieldRepository;
use Fast\CustomField\Repositories\Caches\FieldGroupCacheDecorator;
use Fast\CustomField\Repositories\Eloquent\FieldGroupRepository;
use Fast\CustomField\Repositories\Caches\FieldItemCacheDecorator;
use Fast\CustomField\Repositories\Eloquent\FieldItemRepository;
use Fast\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Fast\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Fast\CustomField\Repositories\Interfaces\FieldItemInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CustomFieldServiceProvider extends ServiceProvider
{

    use LoadAndPublishDataTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $loader = AliasLoader::getInstance();
        $loader->alias('CustomField', CustomFieldSupportFacade::class);

        if (setting('enable_cache', false)) {
            $this->app->singleton(CustomFieldInterface::class, function () {
                return new CustomFieldCacheDecorator(new CustomFieldRepository(new CustomField()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });

            $this->app->singleton(FieldGroupInterface::class, function () {
                return new FieldGroupCacheDecorator(new FieldGroupRepository(new FieldGroup()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });

            $this->app->singleton(FieldItemInterface::class, function () {
                return new FieldItemCacheDecorator(new FieldItemRepository(new FieldItem()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });
        } else {
            $this->app->singleton(CustomFieldInterface::class, function () {
                return new CustomFieldRepository(new CustomField());
            });

            $this->app->singleton(FieldGroupInterface::class, function () {
                return new FieldGroupRepository(new FieldGroup());
            });

            $this->app->singleton(FieldItemInterface::class, function () {
                return new FieldItemRepository(new FieldItem());
            });
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/custom-field')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssetsFolder()
            ->publishPublicFolder();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-custom-field',
                'priority' => 5,
                'parent_id' => null,
                'name' => trans('plugins.custom-field::base.admin_menu.title'),
                'icon' => 'fas fa-cubes',
                'url' => route('custom-fields.list'),
                'permissions' => ['custom-fields.list'],
            ]);
        });

        $this->registerUsersFields();
        $this->registerPagesFields();
        $this->registerBlogFields();
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerUsersFields()
    {
        return CustomFieldSupportFacade::registerRule('other', trans('plugins.custom-field::rules.logged_in_user'), 'logged_in_user', function () {
            $users = $this->app->make(UserInterface::class)->all();
            $userArr = [];
            foreach ($users as $user) {
                $userArr[$user->id] = $user->username . ' - ' . $user->email;
            }

            return $userArr;
        })
        ->registerRule('other', trans('plugins.custom-field::rules.logged_in_user_has_role'), 'logged_in_user_has_role', function () {
            $roles = $this->app->make(RoleInterface::class)->all();
            $rolesArr = [];
            foreach ($roles as $role) {
                $rolesArr[$role->slug] = $role->name . ' - (' . $role->slug . ')';
            }

            return $rolesArr;
        });
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerPagesFields()
    {
        return CustomFieldSupportFacade::registerRule('basic', trans('plugins.custom-field::rules.page_template'), 'page_template', function () {
            return get_page_templates();
        })
        ->registerRule('basic', trans('plugins.custom-field::rules.page'), 'page', function () {
            return $this->app->make(PageInterface::class)
                ->advancedGet([
                    'select' => [
                        'id',
                        'name',
                    ],
                    'order_by' => [
                        'created_at' => 'DESC',
                    ],
                ])
                ->pluck('name', 'id')
                ->toArray();
        })
        ->registerRule('other', trans('plugins.custom-field::rules.model_name'), 'model_name', function () {
            return [
                PAGE_MODULE_SCREEN_NAME => trans('plugins.custom-field::rules.model_name_page'),
            ];
        });
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerBlogFields()
    {
        if (defined('POST_MODULE_SCREEN_NAME')) {
            $categories = get_categories();

            $categoriesArr = [];
            foreach ($categories as $row) {
                $categoriesArr[$row->id] = $row->indent_text . ' ' . $row->name;
            }

            return CustomFieldSupportFacade::registerRuleGroup('blog')
                ->registerRule('blog', trans('plugins.custom-field::rules.category'), CATEGORY_MODULE_SCREEN_NAME, function () use ($categoriesArr) {
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('plugins.custom-field::rules.post_with_related_category'), POST_MODULE_SCREEN_NAME . '.post_with_related_category', function () use ($categoriesArr) {
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('plugins.custom-field::rules.post_format'), POST_MODULE_SCREEN_NAME . '.post_format', function () {
                    $formats = [];
                    foreach (get_post_formats() as $key => $format) {
                        $formats[$key] = $format['name'];
                    }
                    return $formats;
                })
                ->expandRule('other', trans('plugins.custom-field::rules.model_name'), 'model_name', function () {
                    return [
                        POST_MODULE_SCREEN_NAME => trans('plugins.custom-field::rules.model_name_post'),
                        CATEGORY_MODULE_SCREEN_NAME => trans('plugins.custom-field::rules.model_name_category'),
                    ];
                });
        }
    }
}
