<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class Guiest extends Database{
    
    public function __construct(){
        $this->tableName = "guiest"; 
        parent::__construct();
    }
    public function create($data){
        $this->data = $data;
       $result = $this->insert();
       return $result;
    }
    public function getList($columns=false,$where=false){
        $this->columns = $coulumns;
        $this->$where = $where;
        return $this->select();
    }
    public function leftJoin($query=false){
        $this->query = $query;
        return $this->joinLeft();
    }
    public function put($column,$where){
        $this->columns = $column;
        $this->where = $where;                
        return $this->update();
    }
    public function lastInsertedId(){
        return $this->insertedId();
    }
    public function mysqlNumRows($where){
        $this->where = $where;
        return $this->countRow();
    }
} 