<?php

namespace App\Providers;

use App\Services\Messages\Contracts\DepartmentServiceInterface;
use App\Services\Messages\Contracts\DepartmentTypeServiceInterface;
use App\Services\Messages\Contracts\MessageReceiverServiceInterface;
use App\Services\Messages\Contracts\MessageServiceInterface;
use App\Services\Messages\MessageReceiverService;
use App\Services\Messages\DepartmentTypeService;
use App\Services\Messages\DepartmentService;
use App\Services\Messages\MessageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageServiceInterface::class, MessageService::class);
        $this->app->bind(MessageReceiverServiceInterface::class, MessageReceiverService::class);
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);
        $this->app->bind(DepartmentTypeServiceInterface::class, DepartmentTypeService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}