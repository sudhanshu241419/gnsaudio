<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 10:50 AM
 */

class AddToCart extends Database {
    
    public function __construct(){              
        $this->tableName = "temp_mycart";
        parent::__construct();    
    }
    public function insertTempMyCart($data){        
       $this->data = $data;
       $result = $this->insert();
       return $result;
    }
	
    public function updateTempMyCart($columns,$where){
        $this->columns = $columns;
        $this->where = $where;
        return $this->update();
    }
    
    public function getData($columns=false,$where=false){
        $this->columns = $columns;
        $this->where = $where;
        return $this->select();
    }

    public function execureQuery($query){        
        return $this->query($query);
    }
    
    public function getId(){
        return $this->insertedId();
    }
    public function mysqlNumRows($where){
        $this->where = $where;
        return $this->countRow();
    }
    public function deleteItem($where){
        $this->where = $where;
        return $this->customDelete();
    }
} 