<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

namespace SourcekinBundle\Configuration;


class Directories {
    protected $home;
    protected $bin;
    protected $log;
    protected $conf;

    /**
     * Directories constructor.
     *
     * @param $home
     * @param $bin
     * @param $log
     * @param $conf
     */
    public function __construct($home, $bin, $log, $conf) {
        $this->home = $home;
        $this->bin  = $bin;
        $this->log  = $log;
        $this->conf = $conf;
    }

    /**
     * @return mixed
     */
    public function home() {
        return $this->home;
    }

    /**
     * @return mixed
     */
    public function bin() {
        return $this->bin;
    }

    /**
     * @return mixed
     */
    public function log() {
        return $this->log;
    }

    /**
     * @return mixed
     */
    public function conf() {
        return $this->conf;
    }




}