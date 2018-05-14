<?php
//http://irt.localhost/test.php

//require_once __DIR__ . '/../../../autoload.php'; // Autoload files using Composer autoload
require_once 'src/example/DBO.php';

use irt\database\example\DBO;

$dbo = new DBO;
$collection = 'products';

// --------------------------------------------- getCollection
$getCollection = $dbo->demoDB()->getCollection();
echo '<h2>------------------------------ getCollection ------------------------------</h2>';
echo '<pre>';
print_r($getCollection);
echo '</pre>';

// --------------------------------------------- Insert
$dataArray = array(
    'name' => (string) 'Absolute Pressure Gauges - Bellow Type',
    'model' => (string) 'APBL',
    'keyword' => (string) 'đồng hồ đo áp suất'
);
$insert = $dbo->demoDB()->insert($collection, $dataArray);
echo '<h2>------------------------------ Insert ------------------------------</h2>';
echo '<pre>';
print_r($insert);
echo '</pre>';

// --------------------------------------------- getDocument
if($insert['data']){
    $documentID = $insert['data']['id'];
} else {
    $documentID = '';
}
$fieldArray = array(
    'name' => 2,
    'model' => 2,
    'keyword' => 2,
    'image' => 2,
    'document' => 1,
    'ordering' => 3,
    'created_by' => 2
);
$getDocument = $dbo->demoDB()->getDocument($collection, $documentID, $fieldArray);
echo '<h2>------------------------------ getDocument ------------------------------</h2>';
echo '<pre>';
print_r($getDocument);
echo '</pre>';

// --------------------------------------------- findOne
$findArray = array(
    'keyword' => (string) 'đồng hồ đo áp suất',
    'model' => (string) 'APBL'
);
$findOne = $dbo->demoDB()->findOne($collection, $findArray, $fieldArray);
echo '<h2>------------------------------ findOne ------------------------------</h2>';
echo '<pre>';
print_r($findOne);
echo '</pre>';

// --------------------------------------------- getMpDocument
$sortArray = array(
    'ordering' => 1,
    'created_at' => -1
);
$skip = 0;
$limited = 5;
$getMpDocument = $dbo->demoDB()->getMpDocument($collection, $findArray, $fieldArray, $sortArray, $skip, $limited);
echo '<h2>------------------------------ getMpDocument ------------------------------</h2>';
echo '<pre>';
print_r($getMpDocument);
echo '</pre>';

// --------------------------------------------- getMpDocumentInArrayId
$arrayId = array(
    $documentID
);
$getMpDocumentInArrayId = $dbo->demoDB()->getMpDocumentInArrayId($collection, $arrayId, $fieldArray);
echo '<h2>------------------------------ getMpDocumentInArrayId ------------------------------</h2>';
echo '<pre>';
print_r($getMpDocumentInArrayId);
echo '</pre>';

// --------------------------------------------- update
$incArray = null;
$setArray = array(
    'updated_name' => (string) 'Absolute Pressure Gauges - Bellow Type',
);
$unsetArray = null;
$update = $dbo->demoDB()->update($collection, $documentID, $incArray, $setArray, $unsetArray);
echo '<h2>------------------------------ update ------------------------------</h2>';
echo '<pre>';
print_r($update);
echo '</pre>';

// --------------------------------------------- updateMpDocument
$incArray = null;
$setArray = null;
$unsetArray = array(
    'updated_name' => 1
);
$updateMpDocument = $dbo->demoDB()->updateMpDocument($collection, $findArray, $incArray, $setArray, $unsetArray);
echo '<h2>------------------------------ updateMpDocument ------------------------------</h2>';
echo '<pre>';
print_r($updateMpDocument);
echo '</pre>';

// --------------------------------------------- remove
$remove = $dbo->demoDB()->remove($collection, $documentID);
echo '<h2>------------------------------ remove ------------------------------</h2>';
echo '<pre>';
print_r($remove);
echo '</pre>';

// --------------------------------------------- Insert
$insert = $dbo->demoDB()->insert($collection, $dataArray);
echo '<h2>------------------------------ Insert ------------------------------</h2>';
echo '<pre>';
print_r($insert);
echo '</pre>';

// --------------------------------------------- removeMpDocument
$removeMpDocument = $dbo->demoDB()->removeMpDocument($collection, $findArray);
echo '<h2>------------------------------ removeMpDocument ------------------------------</h2>';
echo '<pre>';
print_r($removeMpDocument);
echo '</pre>';

?>