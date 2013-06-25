<?php namespace Capisso\Salty;

class Job {
    private $apiBuilder;
    private $api;
    private $jid;
    private $jobInfo;

    public function __construct($apiBuilder, $api, $jid) {
        $this->apiBuilder = $apiBuilder;
        $this->api = $api;
        $this->jid = $jid;
    }

    public function getJobId() {
        return $this->jid;
    }

    public function isDone() {
        return $this->api->isJobDone($this->jid);
    }

    public function getResults($block=false) {
        if ($block) {
            while (!$this->isDone()) usleep(50000);
        }

        $jobInfo = $this->getJobInfo();
        $parser = $this->getResultParserModule();
        return $parser->parseResult($jobInfo['method'], $jobInfo['arguments'], $jobInfo['results']);
    }

    public function signal($signal) {
        return $this->api->signalJob($this->jid, $signal);
    }

    public function terminate() {
        return $this->api->terminateJob($this->jid);
    }

    public function kill() {
        return $this->api->killJob($this->jid);
    }

    private function getJobInfo() {
        if (!is_null($this->jobInfo)) {
            return $this->jobInfo;
        }

        $jinfo = (array)$this->api->getJobInfo($this->jid);

        $this->jobInfo = array(
            'function' => $jinfo['Function'],
            'results' => (array)$jinfo['Result'],
            'target' => $jinfo['Target'],
            'target_type' => $jinfo['Target-type'],
            'start_time' => $jinfo['Start Time'],
            'user' => $jinfo['User'],
            'arguments' => $jinfo['Arguments']
        );

        $tmp = explode('.', $this->jobInfo['function']);
        $this->jobInfo['module'] = implode('.', array_slice($tmp, 0, -1));
        $this->jobInfo['method'] = $tmp[count($tmp) - 1];

        return $this->jobInfo;
    }

    private function getResultParserModule() {
        $info = $this->getJobInfo();

        return $this->apiBuilder->module($info['module']);
    }
}
