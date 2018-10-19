<?php

namespace irt\database;

use Illuminate\Support\Facades\Auth;

class SDK
{
    
    protected $MONGODB_PATH = '/mongodb';
    
    public function __construct() {
    }

    //-------------------------------------------------------- build --------------------------------------------------------------
    private function build($url, $data) {

        $dev_email = $this->DEV_EMAIL;
        $dev_key = $this->DEV_KEY;
        $database = $this->DATABASE;

        $authentication = base64_encode("$dev_email:$dev_key");
        $myvars = http_build_query(array('data' => json_encode($data)));
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_POST => 1, 
            CURLOPT_POSTFIELDS => $myvars,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER     => array(
                "Authorization: Basic $authentication",
                "Database: $database",
                "Content-Type: application/x-www-form-urlencoded"
            ),
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0'
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $result = array("cURL Error #:" . $err);
        } else {
            return $result = (json_decode($response, true));
            //echo $response;
        }
    }
    
    //------------------------------------------------ getCollection -----------------------------------------------------------------
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
    public function getMpDocument($collection, $findArray = array(), $fieldArray = array(), $sortArray = array(), $skip = 0, $limited = 10) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getMpDocument';
        $data = array(
            'collection' => $collection,
            'findArray' => $findArray,
            'fieldArray' => $fieldArray,
            'sortArray' => $sortArray,
            'skip' => $skip,
            'limited' => $limited
        );
        return $this->build($url, $data);
    }

    //----------------------------------------------------- getMpDocumentInArrayId -----------------------------------------------------------------
    public function getMpDocumentInArrayId($collection, $arrayId = array(), $fieldArray = array()) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/getMpDocumentInArrayId';
        $data = array(
            'collection' => $collection,
            'arrayId' => $arrayId,
            'fieldArray' => $fieldArray
        );
        return $this->build($url, $data);
    }

    //--------------------------------------------------- insert -------------------------------------------------------------------
    public function insert($collection, $dataArray = array()) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/insert';
        $me = Auth::user();
        if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
            $dataArray['created_by'] = isset($dataArray['created_by']) ? $dataArray['created_by'] : (string) $me->email;
            $dataArray['updated_by'] = isset($dataArray['updated_by']) ? $dataArray['updated_by'] : (string) $me->email;
        }
        $data = array(
            'collection' => $collection,
            'dataArray' => $dataArray
        );
        return $this->build($url, $data);
    }

    //-------------------------------------------------- update --------------------------------------------------------------------
    public function update($collection, $documentID, $incArray = null, $setArray = null, $unsetArray = null) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/update';
        $me = Auth::user();
        if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
            $setArray['updated_by'] = isset($setArray['updated_by']) ? $setArray['updated_by'] : (string) $me->email;
        }
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
    public function updateMpDocument($collection, $findArray, $incArray = null, $setArray = null, $unsetArray = null) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/updateMpDocument';
        $me = Auth::user();
        if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
            $setArray['updated_by'] = isset($setArray['updated_by']) ? $setArray['updated_by'] : (string) $me->email;
        }
        $data = array(
            'collection' => $collection,
            'findArray' => $findArray,
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

    //-------------------------------------------------- removeMpDocument --------------------------------------------------------------------
    public function removeMpDocument($collection, $findArray) {
        $url = $this->DEV_URL . $this->MONGODB_PATH . '/removeMpDocument';
        $data = array(
            'collection' => $collection,
            'findArray' => $findArray
        );
        return $this->build($url, $data);
    }

}

?>