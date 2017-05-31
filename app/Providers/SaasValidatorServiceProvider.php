<?php

namespace jamx\Providers;

use Illuminate\Support\ServiceProvider;
use jamx\Extensions\SaasValidator as SaasValidator;

//use Validator;

/**
 *  扩展自定义验证类 服务提供者
 *
 * @author raoyc<king@jinsec.com>
 */
class SaasValidatorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) {
            return new SaasValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
