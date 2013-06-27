<?php

namespace Capisso\Salty\ModuleFacade;

/**
 * Class Status
 *
 * This class is an overlay for salt.modules.status.
 * "Module for returning various status data about a minion. These data can be useful for compiling into stats later."
 * http://docs.saltstack.com/ref/modules/all/salt.modules.status.html
 *
 * @package Capisso\Salty\ModuleFacade
 */
class Status extends BaseFacade {

    public static function getModuleName() {
        return 'status';
    }

    /**
     * Return a composite of all status data and info for this minion. Warning: There is a LOT here!
     *
     * @return \Capisso\Salty\Job
     */
    public function allStatus() {
        return $this->callAsync('all_status', array());
    }

    /**
     * Return the CPU info for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function cpuinfo() {
        return $this->callAsync('cpuinfo', array());
    }

    /**
     * Return the CPU stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function cpustats() {
        return $this->callAsync('cpustats', array());
    }

    /**
     * Return the disk stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function diskstats() {
        return $this->callAsync('diskstats', array());
    }

    /**
     * Return the disk uage for this minion
     *
     * @param $args paths and/or filesystem types
     *
     * @return \Capisso\Salty\Job
     */
    public function diskusage($args) {
        return $this->callAsync('diskusage', array($args));
    }

    /**
     * Return the load averages for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function loadavg() {
        return $this->callAsync('loadavg', array());
    }

    /**
     * Return the CPU stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function meminfo() {
        return $this->callAsync('meminfo', array());
    }

    /**
     * Return the network device stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function netdev() {
        return $this->callAsync('netdev', array());
    }

    /**
     * Return the network stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function nestats() {
        return $this->callAsync('netstats', array());
    }

    /**
     * Return the PID or an empty string if the process is running or not.
     * Pass a signature to use to find the process via ps.
     *
     * @param $sig
     *
     * @return \Capisso\Salty\Job
     */
    public function pid($sig) {
        return $this->callAsync('netstats', array($sig));
    }

    /**
     * Return the process data
     *
     * @return \Capisso\Salty\Job
     */
    public function procs() {
        return $this->callAsync('procs', array());
    }

    /**
     * Return the uptime for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function uptime() {
        return $this->callAsync('uptime', array());
    }

    /**
     * Return the virtual memory stats for this minion
     *
     * @return \Capisso\Salty\Job
     */
    public function vmstats() {
        return $this->callAsync('vmstats', array());
    }

    /**
     * Return a list of logged in users for this minion, using the w command
     *
     * @return \Capisso\Salty\Job
     */
    public function w() {
        return $this->callAsync('w', array());
    }

}