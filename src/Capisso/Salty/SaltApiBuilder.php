<?php namespace Capisso\Salty;

class SaltApiBuilder {
    private $api;
    private $againstNodes = '*';
    private $againstFilterType = 'glob';

    private static $moduleRegistry = array(
        'test' => 'Capisso\\Salty\\ModuleFacade\\Test',
        'virt' => 'Capisso\\Salty\\ModuleFacade\\Virt',
        'status' => 'Capisso\\Salty\\ModuleFacade\\Status'
    );
    private static $wheelRegistry = array(
        'key' => 'Capisso\\Salty\\WheelFacade\\Key'
    );

    public function __construct($api) {
        $this->api = $api;
    }

    /**
     * Returns a new instance of SaltApiBuilder that filters on the specified
     * parameters.
     *
     * @return SaltApiBuilder
     **/
    public function against($nodes, $filterType='glob') {
        $newMe = new self($this->api);

        $newMe->againstNodes = $nodes;
        $newMe->againstFilterType = $filterType;

        return $newMe;
    }

    /**
     * Returns a specific module facade for a given module.
     *
     * @return object
     **/
    public function module($moduleName) {
        if (!isset(self::$moduleRegistry[$moduleName])) {
            throw new \Exception("$moduleName does not exist in SaltApiBuilder's registry");
        }

        $className = self::$moduleRegistry[$moduleName];

        return new $className($this, $this->api, $this->againstNodes, $this->againstFilterType);
    }

    /**
     * Returns a specific module facade for a given wheel module.
     *
     * @return object
     **/
    public function wheelModule($moduleName) {
        if (!isset(self::$wheelRegistry[$moduleName])) {
            throw new \Exception("$moduleName does not exist in SaltApiBuilder's wheel module registry");
        }

        $className = self::$wheelRegistry[$moduleName];

        return new $className($this, $this->api);
    }

    /**
     * Adds a new module to the module registry.
     *
     * @param $moduleName The name of the Salt module you're wrapping
     * @param $moduleClass The class path to the module facade
     **/
    public static function registerModule($moduleName, $moduleClass) {
        if (isset(self::$moduleRegistry[$moduleName])) {
            throw new \Exception("Tried to register $moduleName again in SaltApiBuilder registry");
        }

        if ($moduleClass::getModuleName() != $moduleName) {
            throw new \Exception("Module name mismatch - $moduleName != " . $moduleClass::getModuleName());
        }

        self::$moduleRegistry[$moduleName] = $moduleClass;
    }

    /**
     * Adds a new wheel module to the wheel module registry.
     *
     * @param $moduleName The name of the Salt wheel module you're wrapping
     * @param $moduleClass The class path to the module facade
     **/
    public static function registerWheelModule($moduleName, $moduleClass) {
        if (isset(self::$wheelRegistry[$moduleName])) {
            throw new \Exception("Tried to register $moduleName again in SaltApiBuilder registry");
        }

        if ($moduleClass::getModuleName() != $moduleName) {
            throw new \Exception("Module name mismatch - $moduleName != " . $moduleClass::getModuleName());
        }

        self::$wheelRegistry[$moduleName] = $moduleClass;
    }

    /**
     * Make a Job object for a given Job ID.
     *
     * @return Job
     **/
    public function makeJob($jobId) {
        return new Job($this, $this->api, $jobId);
    }
}
