<?php

namespace Wing5wong\KamarDirectoryServices\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $loadEnvironmentVariables = true;

    protected function getPackageProviders($app)
    {
        return [
            'Wing5wong\KamarDirectoryServices\KamarDirectoryServicesServiceProvider',
            'Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider',
            'Mtownsend\RequestXml\Providers\RequestXmlServiceProvider',
            'Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider',
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('kamar-directory-services.username', env('KAMAR_DS_USERNAME'));
        $app['config']->set('kamar-directory-services.password', env('KAMAR_DS_PASSWORD'));
    }
}
