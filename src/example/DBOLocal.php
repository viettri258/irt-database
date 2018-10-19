<?php
namespace irt\database\example;

//require_once __DIR__ . '/../SDK.php';
require_once __DIR__ . '/../MONGODBDRIVE.php';

//use irt\database\SDK;
use irt\database\MONGODBDRIVE;

//class DBO extends SDK
class DBOLocal extends MONGODBDRIVE
{

    public function demoDB(){

        $this->DATABASE = 'test';
        $this->DEV_EMAIL = 'viettri258@gmail.com';
        $this->DEV_KEY = '935f8a107967f7461c17022';
        $this->DEV_URL = 'http://slave140.owo.vn';        

        return $this;
    }

}

?>