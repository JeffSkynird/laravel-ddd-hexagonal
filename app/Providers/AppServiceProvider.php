<?php

namespace App\Providers;

use App\Invoices\Domain\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Infrastructure\EloquentInvoiceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InvoiceRepositoryInterface::class, EloquentInvoiceRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
