<?php

$m = new MongoClient();
$collection = $m->test->phpmanual;//$m->selectCollection('test', 'phpmanual');

// If an array literal is used, there is no way to access the generated _id
$collection->insert(array('x' => 1));


// The _id is available on an array passed by value
$a = array('x' => 2);
$collection->insert($a);

echo '<pre>';
var_dump($a);
print_r($a);
echo '</pre>';
echo '<hr>';


// The _id is not available on an array passed by reference
$b = array('x' => 3);
$ref = &$b;
$collection->insert($ref);
echo '<pre>';
var_dump($ref);
print_r($ref);
echo '</pre>';
echo '<hr>';


// The _id is available if a wrapping function does not trigger copy-on-write
function insert_no_cow($collection, $document)
{
    $collection->insert($document);
}

$c = array('x' => 4);
insert_no_cow($collection, $c);
echo '<pre>';
var_dump($c);
print_r($c);
echo '</pre>';
echo '<hr>';


// The _id is not available if a wrapping function triggers copy-on-write
function insert_cow($collection, $document)
{
    $document['y'] = 1;
    $collection->insert($document);
}

$d = array('x' => 5);
insert_cow($collection, $d);
echo '<pre>';
var_dump($d);
print_r($d);
echo '</pre>';
echo '<hr>';


$users = array();
for ($i = 0; $i<5; $i++) {
  $users[] = array('username' => 'user'.$i, 'i' => $i);
}

$collection->drop();

$collection->batchInsert($users);

echo '<pre>';
//var_dump($users);
print_r($users);
echo '</pre>';
echo '<hr>';

foreach ($users as $user) {
  echo $user['_id']."\n"; // populated with instanceof MongoId
}

$users = $collection->find()->sort(array('i' => 1));
foreach ($users as $user) {
    echo '<pre>';
    var_dump($user);
    print_r($user);
    echo '</pre>';
    echo '<hr>';
}


// Show all information, defaults to INFO_ALL
/*
$con = new MongoClient();
$database = 'viettridb';
$collection = 'triTest_collection';

$db = $con->$database;
$dataArray['_id'] = new MongoId();
$dataArray['data'] = 'noi dung';
$db->$collection->insert($dataArray);
//new MongoDB\Driver\Manager();*/
//phpinfo();

//-------------

/*
| Link document: http://php.net/manual/en/class.mongocollection.php
*/
/*
$m = new MongoClient();
$db = $m->selectDB('viettridb');
$collection = new MongoCollection($db, 'triTest_collection');

// search for fruits
$fruitQuery = array('Type' => 'Fruit');

$cursor = $collection->find($fruitQuery);
foreach ($cursor as $doc) {
    var_dump($doc);
}

// search for produce that is sweet. Taste is a child of Details. 
$sweetQuery = array('data' => 'noi dung');
echo "Sweet\n";
$cursor = $collection->find($sweetQuery);
foreach ($cursor as $doc) {
    var_dump($doc);
}
*/

?>