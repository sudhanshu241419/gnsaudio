<?php

class Module extends Database {

    public $table_name = '';

    public function __construct() {
        $this->tableName = $this->table_name;
        parent::__construct();
    }

    public function insertData($data) {
        $this->tableName = $this->table_name;
        $this->data = $data;       
        $result = $this->insert();
        return $result;
    }

    public function selectData($columns = false, $where = false) {
        $this->columns = $columns;
        $this->where = $where;
        $this->tableName = $this->table_name; 
        $data = $this->select();
        return $data;
    }

    public function updateData($columns, $where) {
        $this->columns = $columns;
        $this->where = $where;
        $this->tableName = $this->table_name;
        $result = $this->update();
        return $result;
    }

    public function deleteData($id) {
        $this->id = $id;
        $this->tableName = $this->table_name;
        $this->delete();
        return true;
    }

//    public function join($columns = false, $joinTables = false, $where = false, $join = false) {
//        $this->columns = $columns; //table alias with column name
//        $this->where = $where;
//
//        $joinTable = $joinTable;
//        Databse::$join = $join;
//        return $data = join();
//    }

    public function leftJoin($query = false) {
        $data = array();
        if ($query) {
            $this->query = $query;
            $data = $this->joinLeft();
        }
        return $data;
    }

    public function queryParser($query) {
        $result = $this->queryStr($query);
        return $result;
    }

}
