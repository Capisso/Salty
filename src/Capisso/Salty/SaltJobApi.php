<?php

namespace Capisso\Salty;

class SaltJobApi {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    /**
     * Find out if a job is done yet.
     *
     * @return stdClass
     **/
    public function isJobDone($jobId) {
        $resp = $this->api->call('glob', '*', 'saltutil.find_job', array($jobId));
        foreach ($resp as $res) {
            if (isset($res->fun)) return false;
        }
        return true;
    }

    /**
     * Get the result of a previous asynchronous call.
     * Note that this will still return even if the job is incomplete!
     *
     * @return stdClass
     **/
    public function getJobResult($jobId) {
        return $this->api->getJobResult($jobId);
    }

    /**
     * Send a signal to a job.
     **/
    public function signalJob($jobId, $signal) {
        $this->api->call('glob', '*', 'saltutil.signal_job', array($jobId, $signal));
    }

    /**
     * Terminate a job (SIGTERM).
     **/
    public function terminateJob($jobId) {
        $this->api->call('glob', '*', 'saltutil.term_job', array($jobId));
    }

    /**
     * Kill a job (SIGKILL).
     **/
    public function killJob($jobId) {
        $this->api->call('glob', '*', 'saltutil.kill_job', array($jobId));
    }

    /**
     * Get job information for a specified job ID.
     **/
    public function getJobInfo($jobId) {
        $results = (array)$this->api->callRunner(
            'jobs.print_job', array('job_id' => $jobId)
        );
        return $results[$jobId];
    }
}
