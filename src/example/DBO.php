<?php
namespace irt\database\example;

require_once __DIR__ . '/../SDK.php';

use irt\database\SDK;

class DBO extends SDK
{

    public function demoDB(){
        $this->DATABASE = 'pStore';
        $this->DEV_EMAIL = 'demo-user@owo.vn';
        $this->DEV_KEY = 'FKDfU^$Sq@_vf6XJ%zTU*dJQ@dX5?B$gy9MhF9Qb';
        $this->DEV_URL = 'http://slave.owo.vn';
        return $this;
    }

}

?>