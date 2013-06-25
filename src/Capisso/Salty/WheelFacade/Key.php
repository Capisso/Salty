<?php namespace Capisso\Salty\WheelFacade;

class Key extends BaseFacade {
    public static function getModuleName() {
        return 'key';
    }

    public function listAll() {
        $res = $this->call('list_all');
        return array(
            'minions' => array(
                'pending' => $res->minions_pre,
                'rejected' => $res->minions_rejected,
                'accepted' => $res->minions
            ),
            'local' => $res->local
        );
    }

    public function listPending() {
        return $this->call('list_all')->minions_pre;
    }

    public function listRejected() {
        return $this->call('list_all')->minions_rejected;
    }

    public function listAccepted() {
        return $this->call('list_all')->minions;
    }

    public function listLocal() {
        return $this->call('list_all')->local;
    }

    public function getMinionFingerprints($glob='*') {
        return (array)($this->call('finger', array('match' => $glob))->minions);
    }

    public function getLocalFingerprints($glob='*') {
        return (array)($this->call('finger', array('match' => $glob))->local);
    }

    public function getMinionFingerprint($minionName) {
        return $this->call('finger', array('match' => $minionName))->minions->$minionName;
    }

    public function getMinionKeyStrings($glob='*') {
        return (array)($this->call('key_str', array('match' => $glob))->minions);
    }

    public function getMinionKeyString($minionName) {
        return $this->call('key_str', array('match' => $minionName))->minions->$minionName;
    }

    public function accept($match) {
        return $this->call('accept', array('match' => $match));
    }

    public function delete($match) {
        return $this->call('delete', array('match' => $match));
    }

    public function reject($match) {
        return $this->call('reject', array('match' => $match));
    }
}
