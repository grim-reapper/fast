<?php

namespace Fast\Contact\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Contact\Models\ContactReply;
use Fast\Contact\Repositories\Caches\ContactReplyCacheDecorator;
use Fast\Contact\Repositories\Eloquent\ContactReplyRepository;
use Fast\Contact\Repositories\Interfaces\ContactInterface;
use Fast\Contact\Models\Contact;
use Fast\Contact\Repositories\Caches\ContactCacheDecorator;
use Fast\Contact\Repositories\Eloquent\ContactRepository;
use Fast\Contact\Repositories\Interfaces\ContactReplyInterface;
use Event;
use Illuminate\Support\ServiceProvider;
use MailVariable;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactCacheDecorator(new ContactRepository(new Contact));
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyCacheDecorator(new ContactReplyRepository(new ContactReply));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/contact')
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-contact',
                'priority'    => 120,
                'parent_id'   => null,
                'name'        => 'plugins/contact::contact.menu',
                'icon'        => 'far fa-envelope',
                'url'         => route('contacts.index'),
                'permissions' => ['contacts.index'],
            ]);
        });

        MailVariable::setModule(CONTACT_MODULE_SCREEN_NAME)
            ->addVariables([
                'contact_name'    => __('Contact name'),
                'contact_subject' => __('Contact subject'),
                'contact_email'   => __('Contact email'),
                'contact_phone'   => __('Contact phone'),
                'contact_address' => __('Contact address'),
                'contact_content' => __('Contact content'),
            ]);
    }
}
