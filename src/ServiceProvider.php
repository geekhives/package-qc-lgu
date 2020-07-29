<?php

namespace Geekhives\Qclgu;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as ServiceProviderHandler;

class ServiceProvider extends ServiceProviderHandler
{
    /**
     * Perform post-registration booting of services.
     *
     * @param Kernel $kernel
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->publishes([
            dirname(__DIR__) . '/config' => config_path()
        ], 'package_qc_lgu');
    }

    public function register()
    {

    }
}
