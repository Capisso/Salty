<?php namespace Capisso\Salty\ModuleFacade;

class Test extends BaseFacade {
    public static function getModuleName() {
        return 'test';
    }

    public function collatz($start) {
        return $this->callAsync('collatz', array($start));
    }
}
