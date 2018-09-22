<?php

class Enquiry extends Database {
    
    public function __construct(){
        $this->tableName = "enquiry"; 
        parent::__construct();
    }
  
    public function create($data){
        $this->data = $data;
       $result = $this->insert();
       return $result;
    }
    public function leftJoin($query=false){
        $this->query = $query;
        return  $this->joinLeft();
    }
    public function mysqlNumRows($where){
        $this->where = $where;
       return  $this->countRow();
    }

    public function totalRecords($query){
        return  $this->mysql_num_rows($query);
    }
    public function lastInsertedId(){
        return $this->insertedId();
    }
}