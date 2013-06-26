<?php namespace Capisso\Salty\WheelFacade;

abstract class BaseFacade {
    protected $apiBuilder;
    protected $api;

    public function __construct($apiBuilder, $api) {
        $this->apiBuilder = $apiBuilder;
        $this->api = $api;
    }

    public static function getModuleName() {
        throw new \Exception("You must override getModuleName() in subclasses!");
    }

    protected function call($functionName, $args=array()) {
        return $this->api->callWheel(static::getModuleName() . '.' . $functionName, $args);
    }
}
