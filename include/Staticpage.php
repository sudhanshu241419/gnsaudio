<?php

class Staticpage extends Database {
    
    public static $module = '';
    public function __construct(){
        $this->tableName = 'staticpage';
        parent::__construct();
    }
    public function getStaticPage($columns=false,$where=false){
        $this->columns = $columns;
        $this->where = $where;
        return $this->select();
    }
    public function leftjoin($query=false){
        $this->query = $query;
        return self::$this->joinLeft();
    }
    public function totalRecords($where){
        $this->where = $where;
        return self::$this->countRow();
    }
}