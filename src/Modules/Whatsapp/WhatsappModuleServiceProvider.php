<?php

namespace Controlla\Core\Modules\Whatsapp;

use Controlla\Core\Modules\BaseModuleServiceProvider;
use Controlla\Core\Modules\Whatsapp\Services\WhatsappService;

class WhatsappModuleServiceProvider extends BaseModuleServiceProvider
{
    /** @var string */
    protected $id = 'whatsapp';

    /** @var string */
    protected $version = '1.0.0';

    /** @var array */
    protected $migrations = [
        'create_conversations_table',
    ];

    /** @var array */
    protected $models = [
        'Conversation',
        'Message'
    ];

    /** @var array */
    protected $policies = [
        'ConversationPolicy'
    ];

    /** @var array */
    protected $controllers = [
        'ConversationController',
    ];

    /** @var array */
    protected $requests = [
        'Conversation/ConversationStoreRequest',
        'Conversation/ConversationUpdateRequest'
    ];

    /** @var array */
    protected $resources = [
        'Conversation/ConversationResource'
    ];

    /** @var array */
    protected $repositories = [
        'Conversation/ConversationRepository',
        'Conversation/ConversationRepositoryInterface'
    ];

    /** @var array */
    protected $services = [
        'Conversation/ConversationService',
        'Conversation/ConversationServiceInterface'
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WhatsappService::class, function () {
            return new WhatsappService();
        });
    }
}
