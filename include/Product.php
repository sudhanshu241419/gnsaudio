<?php

class Product extends Database{
    
     public function __construct(){
        $this->tableName = "products"; 
        parent::__construct();
    }
    public function getProduct($columns=false,$where=false){
        return  $this->select($columns,$where);
    }
    public function leftJoin($query=false){
        $this->query = $query;
        return  $this->joinLeft();
    }
    public function mysqlNumRows($where){
        $this->where = $where;
       return  $this->countRow();
    }

//    public function queryParser($query){
//        return  $this->querysParser($query);
//    }
    public function totalRecords($query){
        return  $this->mysql_num_rows($query);
    }
}