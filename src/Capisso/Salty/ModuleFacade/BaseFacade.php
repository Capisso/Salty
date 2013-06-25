<?php namespace Capisso\Salty\ModuleFacade;

abstract class BaseFacade {
    protected $apiBuilder;
    protected $api;
    protected $nodes;
    protected $filterType;

    public function __construct($apiBuilder, $api, $nodes, $filterType) {
        $this->apiBuilder = $apiBuilder;
        $this->api = $api;
        $this->nodes = $nodes;
        $this->filterType = $filterType;
    }

    public static abstract function getModuleName();

    public function parseResult($method, $arguments, $results) {
        return array_pop($results);
    }

    protected function callSync($functionName, $args) {
        return $this->api->call($this->filterType, $this->nodes, static::getModuleName() . '.' . $functionName, $args);
    }

    protected function callAsync($functionName, $args) {
        $jobData = $this->api->callAsync($this->filterType, $this->nodes, static::getModuleName() . '.' . $functionName, $args);
        return new \Capisso\Salty\Job($this->apiBuilder, $this->api, $jobData->jid);
    }
}
