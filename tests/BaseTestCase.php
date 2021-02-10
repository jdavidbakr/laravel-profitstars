<?php

namespace jdavidbakr\ProfitStars\Test;

use GuzzleHttp\Client;
use jdavidbakr\ProfitStars\ProfitStarsServiceProvider;
use Mockery;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    public $guzzle;
    
    protected function getPackageProviders($app)
    {
        return [ProfitStarsServiceProvider::class];
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->guzzle = Mockery::mock(Client::class);
        app()->instance(Client::class, $this->guzzle);
    }
}
