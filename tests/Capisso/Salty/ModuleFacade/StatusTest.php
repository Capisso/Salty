<?php

class StatusTest extends PHPUnit_Framework_TestCase
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
        $this->status = $this->saltApiBuilder->against('*')->module('status');
    }

    public function testCpu()
    {

    }
}
