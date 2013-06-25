<?php namespace Capisso\Salty\ModuleFacade;

class Virt extends BaseFacade {
    public static function getModuleName() {
        return 'virt';
    }

    private function requireSingleHost() {
        if ($this->filterType != 'list' || strpos($this->nodes, ',') !== FALSE) {
            throw new \Exception("Must filter by type 'list' and specify a single node to use vm()");
        }
    }

    public function getVm($vmName) {
        $this->requireSingleHost();
        return new Model\VirtVM($this->apiBuilder, $this->api, $this->nodes, $this->filterType, $vmName);
    }

    public function bootVmFromXml($xml) {
        $this->requireSingleHost();
        return $this->callSync('create_xml_str', array($xml))->{$this->nodes};
    }

    public function createVmFromXml($xml) {
        $this->requireSingleHost();
        return $this->callSync('define_xml_str', array($xml))->{$this->nodes};
    }
}
