<?php

namespace irt\database;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use MongoClient;
use MongoId;

class MONGODRIVE
{
        
    public function __construct() {
    }
    
    //-------------------------------------------------------- connectDB --------------------------------------------------------------
    private function connectDB() {
        $con = new MongoClient();
        $database = $this->DATABASE;
        return $db = $con->$database;
    }
    
    //------------------------------------------------ getCollection -----------------------------------------------------------------
    public function getCollection() {
        $db = $this->connectDB();
        $data = $db->getCollectionNames();
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'get_collection',
            'ReturnCode' => 200,
            'ReturnText' => 'Success',
            'data' => $data
        );
        return $resultArray;
    }

    //------------------------------------------------ findOne ----------------------------------------------------------------------
    public function findOne($collection, $findArray = array(), $fieldArray = array()) {
        $db = $this->connectDB();

        $array = $db->$collection->findOne($findArray, $fieldArray);
        $data = array();
        if (($array) && ($fieldArray )) {
            $data = array(
                'id' => (string) $array['_id']
            );
            foreach ($fieldArray as $key => $value) {
                if ($value == 1) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : array();
                } else if ($value == 2) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : (string) '';
                } else if ($value >= 3) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : (int) 0;
                }
            }
        } else if ($array) {
            $data = $array;
            $data['id'] = (string) $array['_id'];
        }
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'find_one',
            'ReturnCode' => 200,
            'ReturnText' => 'Success',
            'data' => $data
        );
        
        return $resultArray;
    }

    //------------------------------------------------ getDocument ----------------------------------------------------------------------
    public function getDocument($collection, $documentID, $fieldArray = array()) {

        $db = $this->connectDB();

        $array = $db->$collection->findOne(array('_id' => new MongoId($documentID)), $fieldArray);
        $data = array();
        if (($array) && ($fieldArray )) {
            $data = array(
                'id' => (string) $array['_id']
            );
            foreach ($fieldArray as $key => $value) {
                if ($value == 1) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : array();
                } else if ($value == 2) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : (string) '';
                } else if ($value >= 3) {
                    $data[$key] = isset($array[$key]) ? $array[$key] : (int) 0;
                }
            }
        } else if ($array) {
            $data = $array;
            $data['id'] = (string) $array['_id'];
        }
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'get_document',
            'ReturnCode' => 200,
            'ReturnText' => 'Success',
            'data' => $data
        );

        return $resultArray;
    }

    //--------------------------------------------------- getMpDocument -------------------------------------------------------------------
    public function getMpDocument($collection, $findArray = array(), $fieldArray = array(), $sortArray = array(), $skip = 0, $limited = 10) {

        $db = $this->connectDB();
        $data = array();

        $documents = $db->$collection->find($findArray, $fieldArray)
                ->sort($sortArray)
                ->skip($skip)
                ->limit($limited);
        $array = iterator_to_array($documents); //Dữ liệu trả về là MongoCursor, nên phải convert lại sang Array
        foreach ($array as $item) {
            $item_new = array();
            if (count($fieldArray)) {
                foreach ($fieldArray as $key => $value) {
                    if ($value == 1) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : array();
                    } else if ($value == 2) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : (string) '';
                    } else if ($value >= 3) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : (int) 0;
                    }
                }
            } else {
                $item_new = $item;
            }
            $id = (string) $item['_id'];
            $item_new['id'] = $id;
            $data[$id] = $item_new;
        }
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'get_multi_document',
            'ReturnCode' => 200, //Thành công
            'ReturnText' => 'Success',
            'data' => $data
        );

        return $resultArray;
    }

    //----------------------------------------------------- getMpDocumentInArrayId -----------------------------------------------------------------
    public function getMpDocumentInArrayId($collection, $arrayId = array(), $fieldArray = array()) {
        $db = $this->connectDB();

        if (count($arrayId)) {
            $mongo_ids = array();
            foreach ($arrayId as $key => $documentID) {
                $mongo_ids[] = new MongoId($documentID);
            }
            $findArray = array(
                '_id' => array(
                    '$in' => $mongo_ids
                )
            );
        } else {
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'get_multi_document',
                'ReturnCode' => 200, //Thành công
                'ReturnText' => 'Success',
                'data' => array()
            );
            return $resultArray;
        }

        $documents = $db->$collection->find($findArray, $fieldArray);
        $array = iterator_to_array($documents); //Dữ liệu trả về là MongoCursor, nên phải convert lại sang Array

        $data = array();
        foreach ($array as $item) {
            if (count($fieldArray)) {
                foreach ($fieldArray as $key => $value) {
                    if ($value == 1) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : array();
                    } else if ($value == 2) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : (string) '';
                    } else if ($value >= 3) {
                        $item_new[$key] = isset($item[$key]) ? $item[$key] : (int) 0;
                    }
                }
            } else {
                $item_new = $item;
            }
            $id = (string) $item['_id'];
            $item_new['id'] = $id;
            $data[$id] = $item_new;
        }
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'get_multi_document',
            'ReturnCode' => 200, //Thành công
            'ReturnText' => 'Success',
            'data' => $data
        );

        return $resultArray;
    }

    //--------------------------------------------------- insert -------------------------------------------------------------------
    public function insert($collection, $dataArray = array()) {

        $dataArray['_id'] = new MongoId();
        $dataArray['created_at'] = isset($dataArray['created_at']) ? $dataArray['created_at'] : Carbon::now('Asia/Ho_Chi_Minh')->toIso8601String();
        $dataArray['updated_at'] = isset($dataArray['updated_at']) ? $dataArray['updated_at'] : Carbon::now('Asia/Ho_Chi_Minh')->toIso8601String();
        $me = Auth::user();
        if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
            $dataArray['created_by'] = isset($dataArray['created_by']) ? $dataArray['created_by'] : (string) $me->email;
            $dataArray['updated_by'] = isset($dataArray['updated_by']) ? $dataArray['updated_by'] : (string) $me->email;
        }
        $db = $this->connectDB();
        $insert = $db->$collection->insert($dataArray);
        if ($insert['ok']) {
            $data = $dataArray;
            $data['id'] = (string) $dataArray['_id'];
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'insert_document',
                'ReturnCode' => 200, //Thành công
                'ReturnText' => 'Success',
                'data' => $data
            );
        } else {
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'insert_document',
                'ReturnCode' => 500,
                'ReturnText' => 'Internal Slave Server error',
                'data' => array()
            );
        }
        
        return $resultArray;
    }

    //-------------------------------------------------- update --------------------------------------------------------------------
    public function update($collection, $documentID, $incArray = null, $setArray = null, $unsetArray = null) {

        $db = $this->connectDB();
        $newData = array();
        if ($incArray) {
            $newData['$inc'] = $incArray;
        }
        if ($setArray) {
            $setArray['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->toIso8601String();
            $me = Auth::user();
            if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
                $setArray['updated_by'] = (string) $me->email;
            }
            $newData['$set'] = $setArray;
        }
        if ($unsetArray) {
            $newData['$unset'] = $unsetArray;
        }

        if (count($newData)) {
            $update = $db->$collection->update(array('_id' => new MongoId($documentID)), $newData);
        }
        if (isset($update) && $update['ok']) {
            $data = $db->$collection->findOne(array('_id' => new MongoId($documentID)));
            $data['id'] = (string) $documentID;
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'update_document',
                'ReturnCode' => 200, //Thành công
                'ReturnText' => 'Success',
                'data' => $data
            );
        } else {
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'update_document',
                'ReturnCode' => 500,
                'ReturnText' => 'Internal Slave Server error',
                'data' => array()
            );
        }
        
        return $resultArray;
    }

    //------------------------------------------------- updateMpDocument ---------------------------------------------------------------------
    public function updateMpDocument($collection, $findArray, $incArray = null, $setArray = null, $unsetArray = null) {

        $db = $this->connectDB();
        $newData = array();
        if ($incArray) {
            $newData['$inc'] = $incArray;
        }
        if ($setArray) {
            $setArray['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->toIso8601String();
            $me = Auth::user();
            if(isset($me->email)){ //Trường hợp dữ liệu từ bên ngoài đưa vào, muốn lưu xuống thì không cần biết ai tạo
                $setArray['updated_by'] = (string) $me->email;
            }
            $newData['$set'] = $setArray;
        }
        if ($unsetArray) {
            $newData['$unset'] = $unsetArray;
        }

        if (count($newData) && count($findArray)) {
            $update = $db->$collection->update($findArray, $newData, array('multiple' => true));
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'update_multi_document',
                'ReturnCode' => 200, //Thành công
                'ReturnText' => 'Success',
                'data' => $update
            );
        } else {
            $resultArray = array(
                'database' => $this->DATABASE,
                'command' => 'update_multi_document',
                'ReturnCode' => 404,
                'ReturnText' => 'Not found. Không tìm thấy yêu cầu tương tứng.',
                'data' => array()
            );
        }
        
        return $resultArray;
    }

    //-------------------------------------------------- remove --------------------------------------------------------------------
    public function remove($collection, $documentID) {

        $db = $this->connectDB();
        $remove = $db->$collection->remove(array('_id' => new MongoId($documentID)));
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'remove_document',
            'ReturnCode' => 200, //Thành công
            'ReturnText' => 'Success',
            'data' => $remove
        );
        
        return $resultArray;
    }

    //-------------------------------------------------- removeMpDocument --------------------------------------------------------------------
    public function removeMpDocument($collection, $findArray) {

        $db = $this->connectDB();
        $remove = $db->$collection->remove($findArray);
        $resultArray = array(
            'database' => $this->DATABASE,
            'command' => 'remove_multi_document',
            'ReturnCode' => 200, //Thành công
            'ReturnText' => 'Success',
            'data' => $remove
        );
        
        return $resultArray;
    }

}

?>