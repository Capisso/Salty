<?php

class SaltApiBuilderTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->saltApi = new \Capisso\Salty\SaltApi(
            getenv('SALTAPI_HOST'), getenv('SALTAPI_PORT'),
            'pam',
            array(
                'username' => getenv('SALTAPI_USERNAME'),
                'password' => getenv('SALTAPI_PASSWORD')
            ),
            false
        );
        $this->saltApiBuilder = new \Capisso\Salty\SaltApiBuilder($this->saltApi);
    }

    public function testCollatz()
    {
        $this->saltApiBuilder->against('*')->module('test')->collatz(5)->getResults(true);
    }

    public function testRecreateJob()
    {
        $originalJob = $this->saltApiBuilder->against('*')->module('test')->collatz(5);
        $reconstitutedJob = $this->saltApiBuilder->makeJob($originalJob->getJobId());
        $this->assertEquals($originalJob->getResults(true), $reconstitutedJob->getResults(true));
    }
}
