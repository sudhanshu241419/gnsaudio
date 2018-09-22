<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class Auth {
    public $tableName = 'users';
    public static $module = '';
    public function __construct(){
        self::$module = new Module($this->tableName);
    }
    public function authentication($columns=false,$where=false){
        return self::$module->select($columns,$where);
    }

    public function insertUser($data){
       $result = self::$module->insert($data);
       return $result;
    }
    public function getUser($columns=false,$where=false){
        return self::$module->select($columns,$where);
    }
    public function joinLeft($query=false){
        return self::$module->joinLeft($query);
    }
	public function update($column,$where){
		return self::$module->update($column,$where);
	}
    public function insertedId(){
        return self::$module->insertedId();
    }
    public function countRow($where){
        return self::$module->countRow($where);
    }
} 