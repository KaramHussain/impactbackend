<?php

namespace App\Providers;

use App\carepays_providers\provider;
use App\insurance\payer_list;
use App\manager\connectionManager;
use App\paymentGateways\gateway;
use App\paymentGateways\gateways\stripeGateway;
use App\remark_code;
use App\search\diseases\icd10cm;
use App\search\diseases\sub_category;
use App\search\Treatment\category;
use App\search\Treatment\children_term;
use App\search\Treatment\code;
use App\search\Treatment\term;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         /*
        Ashok Swami  21/08/2023 
|--------------------------------------------------------
|  Register custom migration paths
|  We specify sub-directory for each version, like:
|      - database/migrations/providers
|      - database/migrations/search_engine
|      - etc.
|  You may use DIRECTORY_SEPARATOR instead of /
|--------------------------------------------------------
*/

 $this->loadMigrationsFrom([
    database_path().'/migrations/providers',
    database_path().'/migrations/search_engine',
 ]);
      
        Stripe::setApiKey(config('services.stripe.secret'));

        $this->app->singleton(connectionManager::class, function() {
            return new connectionManager;
        });

        Relation::morphMap([
            'term'          => term::class,
            'children_term' => children_term::class,
            'category'      => category::class,
            'sub_category'  => sub_category::class,
            'code'          => code::class,
            'icd'           => icd10cm::class,
            'provider'      => provider::class,
            'payer_list'    => payer_list::class,
            'remark_code'   => remark_code::class
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(gateway::class, function () {
            return new stripeGateway;
        });
    }
}
