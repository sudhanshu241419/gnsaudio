<?php
Class Material extends Database{
    public function __construct(){
        $this->tableName = 'material';
        parent::__construct();
    }
    public function getMaterial($columns=false,$where=false){
        return $this->select($columns,$where);
    }
}