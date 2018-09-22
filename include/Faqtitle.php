<?php

class Faqtitle extends Database {    
    
    public function __construct(){
        $this->tableName = "static_page_title"; 
        parent::__construct();
    }
    public function get($columns=false,$where=false){
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
    public function totalRecords($query){
        return  $this->mysql_num_rows($query);
    }
}