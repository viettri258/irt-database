<?php
require_once __DIR__ . '/../../../autoload.php'; // Autoload files using Composer autoload

use irt\database\example\DBO;

$dbo = new DBO;
$result = $dbo->demoDB()->getCollection();

echo '<pre>';
print_r($result);
echo '</pre>';
?>