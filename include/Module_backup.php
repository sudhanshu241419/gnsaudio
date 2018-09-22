<?php

class Module_backup extends Database{

    public $tableName = '';
    public $totalRow = '';
    public $insertedId = '';
    public $pdo;

    public function __construct($tableName) {  
        $this->tableName = $tableName;
    }

    public function create($data) {
         $this->data = $data;
         $this->tableName = $this->tableName;
        $result =  $this->insert();
        return $result;
    }

    public function get($columns = false, $where = false) {        
         $this->columns = $columns;
         $this->where = $where;
         $this->conn = $this->pdo;
         $this->tableName = $this->tableName;
        
        $data = $this->select();
        return $data;
    }

    public function put($columns, $where) {
         $this->columns = $columns;
         $this->where = $where;
         $this->tableName = $this->tableName;
        $result =  $this->update();
        return $result;
    }

    public function destroy($id) {
         $this->id = $id;
         $this->tableName = $this->tableName;
         $this->delete();
        return true;
    }

    public function joins($columns = false, $joinTables = false, $where = false, $join = false) {
         $this->columns = $columns; //table alias with column name
         $this->where = $where;
         $this->tableName = $this->tableName;
         $this->joinTable = $joinTable;
        Databse::$join = $join;
        return $data =  $this->join();
    }

    public function joinsLeft($query = false) {       
        $data = array();
        if ($query) {
            print_r($this->pdo);
             $this->query = $query;
            $data =  $this->joinLeft();
        }
        return $data;
    }

    public function mysqlNumRows($where = false) {
         $this->tableName = $this->tableName;
        if ($where) {
             $this->where = $where;
        } else {
             $this->where = " WHERE 1=1";
        }
        return $this->totalRow =  $this->countRow();
    }

    public function querysParser($query) {
        if (!empty($query)) {
            $result =  $this->queryParser($query);
            $row = mysql_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }

    public function totalRows($query) {
        if (!empty($query)) {
            $this->query = $query;
            $result =  $this->mysql_num_rows();
            return $result;
        } else {
            return false;
        }
    }

    public function getId() {
        return $this->insertedId =  $this->insertedId();
    }

}
