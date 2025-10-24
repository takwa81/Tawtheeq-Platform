<?php

namespace App\Providers;

use App\Interfaces\{
    AdsRepositoryInterface,

    DefinitionRepositoryInterface,
    ServiceRepositoryInterface,
    ServiceScheduleRepositoryInterface,
    UserInterface,
    AttributeKeyOptionsRepositoryInterface,
    AttributeKeyRepositoryInterface,
    ServiceSocialMediaRepositoryInterface,
    ServiceAttachmentsRepositoryInterface,
    ServiceAttributeRepositoryInterface,
    ServiceOwnerAttributesRepositoryInterface,
    TagRepositoryInterface
};

use App\Repositories\{
    AdsRepository,

    DefinitionRepository,
    ServiceRepository,
    ServiceScheduleRepository,
    UserRepository,
    AttributeKeyOptionsRepository,
    AttributeKeyRepository,
    ServiceSocialMediaRepository,
    ServiceAttachmentsRepository,
    ServiceAttributeRepository,
    ServiceOwnerAttributesRepository,
    TagRepository
};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $this->app->bind(DefinitionRepositoryInterface::class, DefinitionRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ServiceScheduleRepositoryInterface::class, ServiceScheduleRepository::class);
        $this->app->bind(AttributeKeyOptionsRepositoryInterface::class, AttributeKeyOptionsRepository::class);
        $this->app->bind(AttributeKeyRepositoryInterface::class, AttributeKeyRepository::class);
        $this->app->bind(ServiceSocialMediaRepositoryInterface::class, ServiceSocialMediaRepository::class);
        $this->app->bind(ServiceAttachmentsRepositoryInterface::class, ServiceAttachmentsRepository::class);
        $this->app->bind(ServiceAttributeRepositoryInterface::class, ServiceAttributeRepository::class);
        $this->app->bind(ServiceOwnerAttributesRepositoryInterface::class, ServiceOwnerAttributesRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);



    }

    public function boot(): void
    {
        //
    }
}
