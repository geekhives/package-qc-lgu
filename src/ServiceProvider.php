<?php

namespace Geekhives\QcLgu;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes(
            [
                __DIR__ . '/config/package_qc_lgu.php' => config_path('package_qc_lgu.php'),
            ], 'qc_lgu'
        );
    }
}
