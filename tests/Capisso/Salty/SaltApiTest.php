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
        $jobApi = new \Capisso\Salty\SaltJobApi($this->saltApi);

        $ret = $this->saltApi->callAsync('glob', '*', 'cmd.retcode', array('sleep 1'));
        $this->assertFalse($jobApi->isJobDone($ret->jid));
        $this->assertEquals(count((array)$jobApi->getJobResult($ret->jid)), 0);
        sleep(1.3);
        $this->assertTrue($jobApi->isJobDone($ret->jid));
        $this->assertNotEquals(count((array)$jobApi->getJobResult($ret->jid)), 0);
    }

    public function testWheelCommands()
    {
        $ret = $this->saltApi->callWheel('key.list_all');
        $this->assertTrue(isset($ret->minions_pre));
        $this->assertTrue(isset($ret->minions_rejected));
        $this->assertTrue(isset($ret->minions));
        $this->assertTrue(isset($ret->local));
    }

    public function testRunnerCommands()
    {
        $activeJobs = $this->saltApi->callRunner('jobs.active');
        $activeJobsArray = (array)$activeJobs;
        $this->assertEquals(0, count($activeJobsArray));
    }
}
