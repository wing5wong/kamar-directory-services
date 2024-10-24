<?php

namespace Wing5wong\KamarDirectoryServices\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('kamar-directory-services.serviceName', '123123123');
        $app['config']->set('kamar-directory-services.serviceVersion', "1.3.4");
        $app['config']->set('kamar-directory-services.infoUrl', '123123123');
        $app['config']->set('kamar-directory-services.privacyStatement', '123123123');
        $app['config']->set('kamar-directory-services.options', []);
        $app['config']->set('kamar-directory-services.authSuffix', '123123123');
        $app['config']->set('kamar-directory-services.password', 'validPassword');
        $app['config']->set('kamar-directory-services.username', 'validUsername');
        $app['config']->set('app.debug', true);
    }

    protected function getPackageProviders($app)
    {
        return [
            'Mtownsend\RequestXml\Providers\RequestXmlServiceProvider',
            'Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider',
            'Wing5wong\KamarDirectoryServices\KamarDirectoryServicesServiceProvider',
        ];
    }

    /**
     * Resolve application core configuration implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
    }
}
