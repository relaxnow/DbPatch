<?php

class DbPatch_Core_Config
{
    protected $config = null;

    public function __construct($opts)
    {
        //@todo opts can overrule configs!
        $filename = '';

        if (is_null($filename) || !file_exists($filename)) {
            $filename = $this->searchConfigFile();
        }

        if (is_null($filename)) {
            throw new Exception('No config file found');
        }

        $type = $this->detectConfigType($filename);

        switch ($type) {
            case 'php' :
                $dbPatchConfig = array();
                require_once $filename;
                $this->config = new Zend_Config($dbPatchConfig);
            case 'ini' :
                $this->config = new Zend_Config_Ini($filename, 'dbPatch');
                break;
        }

    }

    protected function searchConfigFile()
    {
        return './dbpatch.ini';
    }

    protected function detectConfigType($filename)
    {
        return 'ini';
    }

    public function getConfig()
    {
        return $this->config;
    }
}