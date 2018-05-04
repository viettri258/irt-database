<?php
namespace irt\database\example;

use irt\database\SDK;

class DBO extends SDK
{

    public function demoDB(){
        $this->DATABASE = 'demoDB';
        $this->DEV_EMAIL = 'demo-user@owo.vn';
        $this->DEV_KEY = 'wyVg8ZX_43+rC3V-xJs!_n^L#LdXhW-#&979d-JG';
        $this->DEV_URL = 'http://slave.owo.vn';
        return $this;
    }

}

?>