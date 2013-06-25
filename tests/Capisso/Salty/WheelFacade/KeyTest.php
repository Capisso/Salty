<?php

class KeyTest extends PHPUnit_Framework_TestCase
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
        $this->key = $this->saltApiBuilder->wheelModule('key');
    }

    public function testListAll()
    {
        $res = $this->key->listAll();
        $this->assertArrayHasKey('minions', $res);
        $this->assertArrayHasKey('pending', $res['minions']);
        $this->assertArrayHasKey('rejected', $res['minions']);
        $this->assertArrayHasKey('accepted', $res['minions']);
        $this->assertArrayHasKey('local', $res);
    }

    public function testGetMinionFingerprints()
    {
        $res = $this->key->getMinionFingerprints('*');
        $this->assertGreaterThan(0, count($res));
    }

    public function testGetLocalFingerprints()
    {
        $res = $this->key->getLocalFingerprints();
        $this->assertGreaterThan(0, count($res));
    }

    public function testGetMinionFingerprint()
    {
        // get name of minion
        $res = $this->key->getMinionFingerprints('*');
        $this->assertGreaterThan(0, count($res));
        $minionNames = array_keys($res);
        $minionName = $minionNames[0];

        // ask for key
        $minionKey = $this->key->getMinionFingerprint($minionName);
        $this->assertEquals($minionKey, $res[$minionName]);
    }

    public function testGetMinionKeyStrings()
    {
        $res = $this->key->getMinionKeyStrings('*');
        $this->assertGreaterThan(0, count($res));
    }

    public function testGetMinionKeyString()
    {
        // get name of minion
        $res = $this->key->getMinionKeyStrings('*');
        $this->assertGreaterThan(0, count($res));
        $minionNames = array_keys($res);
        $minionName = $minionNames[0];

        // ask for key
        $minionKey = $this->key->getMinionKeyString($minionName);
        $this->assertEquals($minionKey, $res[$minionName]);
    }
}
