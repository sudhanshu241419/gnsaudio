<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class Category extends Database{
    
    public $module = '';
    
    public function __construct(){        
        $this->tableName = "categories";  
        parent::__construct();
    }
    public function getCategory($columns=false,$where=false){
        $this->columns = $columns;
        $this->where = $where;
       return $this->select();
    }
    public function join($query=false){
        return $this->joinLeft($query);
    }

} 