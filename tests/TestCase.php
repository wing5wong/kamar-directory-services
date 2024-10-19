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
        $app['config']->set('kamar-directory-services.infoUrl', '123123123');
        $app['config']->set('kamar-directory-services.privacyStatement', '123123123');
        $app['config']->set('kamar-directory-services.options', []);
        $app['config']->set('kamar-directory-services.authSuffix', '123123123');
        $app['config']->set('kamar-directory-services.password', '123123123');
        $app['config']->set('kamar-directory-services.username', '123123123');
    }

    protected function getPackageProviders($app)
    {
        return [
            'Mtownsend\RequestXml\Providers\RequestXmlServiceProvider',
            'Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider',
            'Wing5wong\KamarDirectoryServices\KamarDirectoryServicesServiceProvider',
        ];
    }
}
