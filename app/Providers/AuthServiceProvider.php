<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\WasteReport;
use App\Models\CarbonFootprint;
use App\Models\FoodListing;
use App\Policies\WasteReportPolicy;
use App\Policies\CarbonFootprintPolicy;
use App\Policies\FoodListingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        WasteReport::class => WasteReportPolicy::class,
        CarbonFootprint::class => CarbonFootprintPolicy::class,
        FoodListing::class => FoodListingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
