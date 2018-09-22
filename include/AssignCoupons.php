<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class AssignCoupons {
    public $tableName = 'assign_coupons';
    public static $module = '';
    public function __construct(){
        self::$module = new Module($this->tableName);
    }
    public function insert($data){
       $result = self::$module->insert($data);
       return $result;
    }
	
	public function update($columns,$where){
		return self::$module->update($columns,$where);
	}
    public function select($columns=false,$where=false){
        return self::$module->select($columns,$where);
    }

    public function queryParser($query){
        
        return self::$module->queryParser($query);
    }
    
    public function insertedId(){
        return self::$module->insertedId();
    }
    public function countRow($where){
        return self::$module->countRow($where);
    }
    public function delete($where){
        return self::$module->delete($where);
    }
} 