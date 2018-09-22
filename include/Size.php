<?php

Class Size{
	public $tableName = 'size_price';
    public static $module = '';
    public function __construct(){
        self::$module = new Module($this->tableName);
    }
    public function getSize($columns=false,$where=false){
        return self::$module->select($columns,$where);
    }
}