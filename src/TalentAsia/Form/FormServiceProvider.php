<?php

namespace TalentAsia\Form;

use TalentAsia\Form\ErrorStore\IlluminateErrorStore;
use TalentAsia\Form\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
    }

    protected function registerErrorStore()
    {
        $this->app->singleton('talentasia.form.errorstore', function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput()
    {
        $this->app->singleton('talentasia.form.oldinput', function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app->singleton('talentasia.form', function ($app) {
            $formBuilder = new FormBuilder;
            $formBuilder->setErrorStore($app['talentasia.form.errorstore']);
            $formBuilder->setOldInputProvider($app['talentasia.form.oldinput']);
            $formBuilder->setToken($app['session.store']->token());

            return $formBuilder;
        });
    }

    public function provides()
    {
        return ['talentasia.form'];
    }
}
