<?php namespace Capisso\Salty;

class SaltApiBuilder {
    private $api;
    private $againstNodes = '*';
    private $againstFilterType = 'glob';

    private static $moduleRegistry = array(
        'test' => 'Capisso\\Salty\\ModuleFacade\\Test'
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
     * Make a Job object for a given Job ID.
     *
     * @return Job
     **/
    public function makeJob($jobId) {
        return new Job($this, $this->api, $jobId);
    }
}
