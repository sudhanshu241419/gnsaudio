<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class Review extends Database{
   
    public function __construct(){
       $this->tableName = "user_review"; 
       parent::__construct(); 
    }
    public function insertData($data){
       $result = $this->insert($data);
       return $result;
    }
	
    public function updateData($columns,$where){
            return $this->update($columns,$where);
    }
    public function selectData($columns=false,$where=false){
        return $this->select($columns,$where);
    }

    public function queryParser($query){
        
        return $this->query($query);
    }
    
    public function lastId(){
        return $this->insertedId();
    }
    public function countData($where){
        $this->where = $where;
        return $this->countRow();
    }
    public function deleteData($id){
        $this->id = $id;
        return $this->delete();
    }
} 