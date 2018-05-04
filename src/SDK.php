<?php

namespace irt\database;

class SDK
{
    
    protected $MONGODB_PATH = '/mongodb';
    
    public function __construct() {
    }

    //-------------------------------------------------------- build --------------------------------------------------------------
    private function build($url, $data) {
        $varArray = array(
            'account' => array(
                'email' => $this->DEV_EMAIL,
                'key' => $this->DEV_KEY,
                'database' => $this->DATABASE
            ),
            'data' => $data
        );

        $myvars = json_encode($varArray);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_POSTFIELDS => $myvars,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $result = array("cURL Error #:" . $err);
        } else {
            return $result = (json_decode($response, true));
        }
    }
    
    public function getCollection(){
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getCollection';
        $data = array(
        );
        return $this->build($url, $data);
    }

    //------------------------------------------------ findOne ----------------------------------------------------------------------
    public function findOne($collection, $findArray = array(), $fieldArray = array()) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/findOne';
        $data = array(
            'collection' => $collection,
            'findArray' => $findArray,
            'fieldArray' => $fieldArray,
        );
        return $this->build($url, $data);
    }

    //------------------------------------------------ getDocument ----------------------------------------------------------------------
    public function getDocument($collection, $documentID, $fieldArray = array()) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getDocument';
        $data = array(
            'collection' => $collection,
            'documentID' => $documentID,
            'fieldArray' => $fieldArray,
        );
        return $this->build($url, $data);
    }

    //--------------------------------------------------- getMpDocument -------------------------------------------------------------------
    public function getMpDocument($collection, $whereArray = array(), $fieldArray = array(), $sortArray = array(), $skip = 0, $limited = 0) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getMpDocument';
        $data = array(
            'collection' => $collection,
            'whereArray' => $whereArray,
            'fieldArray' => $fieldArray,
            'sortArray' => $sortArray,
            'skip' => $skip,
            'limited' => $limited
        );
        return $this->build($url, $data);
    }

    //----------------------------------------------------- getMpDocumentInArrayId -----------------------------------------------------------------
    public function getMpDocumentInArrayId($collection, $arrayId = array(), $fieldArray = array(), $sortArray = array(), $skip = 0, $limited = 0) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getMpDocumentInArrayId';
        $data = array(
            'collection' => $collection,
            'arrayId' => $arrayId,
            'fieldArray' => $fieldArray,
            'sortArray' => $sortArray,
            'skip' => $skip,
            'limited' => $limited
        );
        return $this->build($url, $data);
    }

    //--------------------------------------------------- insert -------------------------------------------------------------------
    public function insert($collection, $dataArray = array()) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/insert';
        $data = array(
            'collection' => $collection,
            'dataArray' => $dataArray
        );
        return $this->build($url, $data);
    }

    //-------------------------------------------------- update --------------------------------------------------------------------
    public function update($collection, $documentID, $incArray = null, $setArray = null, $unsetArray = null) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/update';
        $data = array(
            'collection' => $collection,
            'documentID' => $documentID,
            'incArray' => $incArray,
            'setArray' => $setArray,
            'unsetArray' => $unsetArray
        );
        return $this->build($url, $data);
    }

    //------------------------------------------------- updateMpDocument ---------------------------------------------------------------------
    public function updateMpDocument($collection, $whereArray, $incArray = null, $setArray = null, $unsetArray = null) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/updateMpDocument';
        $data = array(
            'collection' => $collection,
            'whereArray' => $whereArray,
            'incArray' => $incArray,
            'setArray' => $setArray,
            'unsetArray' => $unsetArray
        );
        return $this->build($url, $data);
    }

    //-------------------------------------------------- remove --------------------------------------------------------------------
    public function remove($collection, $documentID) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/remove';
        $data = array(
            'collection' => $collection,
            'documentID' => $documentID
        );
        return $this->build($url, $data);
    }

}

?>