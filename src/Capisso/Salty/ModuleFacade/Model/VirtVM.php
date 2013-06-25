<?php namespace Capisso\Salty\ModuleFacade\Model;

class VirtVM extends \Capisso\Salty\ModuleFacade\BaseFacade {
    protected $vmName;

    public static function getModuleName() {
        return 'virt';
    }

    public function __construct($apiBuilder, $api, $nodes, $filterType, $vmName) {
        parent::__construct($apiBuilder, $api, $nodes, $filterType);
        $this->vmName = $vmName;
    }

    protected function callSyncStrip($functionName, $args, $onlyOneLayer=true) {
        $ret = $this->callSync($functionName, $args);
        $nodeName = $this->nodes;
        $vmName = $this->vmName;
        $ret = $ret->$nodeName;
        if (!$onlyOneLayer) {
            $ret = $ret->$vmName;
        }
        return $ret;
    }

    /**
     * Power-on a VM
     **/
    public function start() {
        return $this->callSyncStrip('start', array($this->vmName));
    }

    /**
     * Send a Ctrl-Alt-Delete attention sequence to a VM.
     **/
    public function ctrlAltDel() {
        return $this->callSyncStrip('ctrl_alt_del', array($this->vmName));
    }

    /**
     * Hard power-off a VM.
     **/
    public function powerOff() {
        return $this->callSyncStrip('destroy', array($this->vmName));
    }

    /**
     * Get disks for this VM.
     **/
    public function getDisks() {
        return $this->callSyncStrip('get_disks', array($this->vmName));
    }

    /**
     * Get graphics for this VM.
     **/
    public function getGraphics() {
        return $this->callSyncStrip('get_graphics', array($this->vmName));
    }

    /**
     * Get MAC addresses for this VM.
     **/
    public function getMacAddresses() {
        return $this->callSyncStrip('get_macs', array($this->vmName));
    }

    /**
     * Get NICs for this VM.
     **/
    public function getNics() {
        return $this->callSyncStrip('get_nics', array($this->vmName));
    }

    /**
     * Get XML definition for this VM.
     **/
    public function getXml() {
        return $this->callSyncStrip('get_xml', array($this->vmName));
    }

    /**
     * Migrate shared storage.
     **/
    public function migrateSharedStorage($target, $ssh=false) {
        return $this->callSyncStrip('migrate', array($this->vmName, $target, $ssh));
    }

    /**
     * Migrate non-shared storage "all" migration.
     **/
    public function migrateNonsharedStorage($target, $ssh=false) {
        return $this->callSyncStrip('migrate_non_shared', array($this->vmName, $target, $ssh));
    }

    /**
     * Migrate non-shared storage "all" migration.
     **/
    public function migrateNonsharedIncStorage($target, $ssh=false) {
        return $this->callSyncStrip('migrate_non_shared_inc', array($this->vmName, $target, $ssh));
    }

    /**
     * Pause VM.
     **/
    public function pause() {
        return $this->callSyncStrip('pause', array($this->vmName));
    }

    /**
     * Purge VM (and also disk images if parameter is true).
     **/
    public function purge($purgeVmDisk=false) {
        return $this->callSyncStrip('purge', array($this->vmName, $purgeVmDisk));
    }

    /**
     * Reboot VM using an ACPI request.
     **/
    public function reboot() {
        return $this->callSyncStrip('reboot', array($this->vmName));
    }

    /**
     * Reset VM (ala physical reset switch).
     **/
    public function reset() {
        return $this->callSyncStrip('reset', array($this->vmName));
    }

    /**
     * Resume a paused VM.
     **/
    public function resume() {
        return $this->callSyncStrip('resume', array($this->vmName));
    }

    /**
     * Set autostart (should VM start with host?)
     **/
    public function setAutostart($shouldAutostart) {
        return $this->callSyncStrip('set_autostart', array($this->vmName, $shouldAutostart ? 'on' : 'off'));
    }

    /**
     * Set allocated memory for this VM (in MB).
     * Second parameter controls whether VM's on-disk config should be updated too.
     **/
    public function setMemory($memory, $onDisk) {
        return $this->callSyncStrip('setmem', array($this->vmName, $memory, $onDisk));
    }

    /**
     * Set number of allocated vCPUs for this VM.
     * Second parameter controls whether VM's on-disk config should be updated too.
     **/
    public function setVcpus($vcpus, $onDisk) {
        return $this->callSyncStrip('setvcpus', array($this->vmName, $vcpus, $onDisk));
    }

    /**
     * Soft-shutdown a VM.
     **/
    public function shutdown() {
        return $this->callSyncStrip('shutdown', array($this->vmName));
    }

    /**
     * "Undefine" a VM, i.e. remove it. Only works if VM powered down.
     **/
    public function remove() {
        return $this->callSyncStrip('undefine', array($this->vmName));
    }

    /**
     * Return CPUtime usage information for this VM.
     **/
    public function cputime() {
        return $this->callSyncStrip('vm_cputime', array($this->vmName), false);
    }

    /**
     * Return disk I/O usage information for this VM.
     **/
    public function diskstats() {
        return $this->callSyncStrip('vm_diskstats', array($this->vmName), false);
    }

    /**
     * Return information about this VM.
     **/
    public function info() {
        return $this->callSyncStrip('vm_info', array($this->vmName), false);
    }

    /**
     * Return network usage information for this VM.
     **/
    public function netstats() {
        return $this->callSyncStrip('vm_netstats', array($this->vmName), false);
    }

    /**
     * Return state of this VM.
     **/
    public function state() {
        return $this->callSyncStrip('vm_state', array($this->vmName), false);
    }
}
