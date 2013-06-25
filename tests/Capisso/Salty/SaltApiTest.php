<?php

class SaltApiTest extends PHPUnit_Framework_TestCase
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
    }

    public function testPing()
    {
        foreach ($this->saltApi->call('glob', '*', 'test.ping') as $result) {
            $this->assertEquals($result, 1);
        }
    }

    public function testAsyncCommands()
    {
        $ret = $this->saltApi->callAsync('glob', '*', 'cmd.retcode', array('sleep 1'));
        $this->assertFalse($this->saltApi->isJobDone($ret->jid));
        $this->assertEquals(count((array)$this->saltApi->getJobResult($ret->jid)), 0);
        sleep(1.3);
        $this->assertTrue($this->saltApi->isJobDone($ret->jid));
        $this->assertNotEquals(count((array)$this->saltApi->getJobResult($ret->jid)), 0);
    }
}
