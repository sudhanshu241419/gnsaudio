<?php

Class Price extends Database{

    public function __construct(){
        $this->tableName =  'price';
        parent::__construct();
    }
    public function getPrice($columns=false,$where=false){
        $this->columns = $columns;
        $this->where = $where;
        return $this->select();
    }
}