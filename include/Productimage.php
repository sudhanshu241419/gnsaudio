<?php

class Productimage extends Database {    
   
    public function __construct(){
        $this->tableName = "products_image"; 
        parent::__construct();       
    }
    public function getImages($columns=false,$where=false){
        $this->columns =$columns;
        $this->where = $where;
        return  $this->select();
    }
    public function leftJoin($query=false){
        $this->query = $query;
        return  $this->joinLeft();
    }
    public function mysqlNumRows($where){
        $this->where = $where;
       return  $this->countRow();
    }
}