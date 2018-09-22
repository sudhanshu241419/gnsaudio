<?php

class Emailtofriend {
    public $tableName = 'email_to_friend';
    public static $module = '';
    public function __construct(){
        self::$module = new Module($this->tableName);
    }
    public function select($columns=false,$where=false){
        return self::$module->select($columns,$where);
    }
	public function insert($data){
       $result = self::$module->insert($data);
       return $result;
    }
    public function joinLeft($query=false){
        return self::$module->joinLeft($query);
    }
    public function countRow($where){
        return self::$module->countRow($where);
    }

    public function queryParser($query){
        return self::$module->queryParser($query);
    }
	public function insertedId(){
		return self::$module->insertedId();
	}
}