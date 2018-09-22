<?php

/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/6/14
 * Time: 5:08 PM
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
 * https://phpdelusions.net/pdo
 */
class Database {

    protected $tableName = "";
    protected $data = "";
    protected $columns = "";
    protected $where = "";
    protected $id = "";
    protected $joinTables = ""; // it will pair of key and value. key will alias of table
    protected $join = "";
    public $query = '';
    const FORMAT_SQLDATETIME="Y-m-d H:i:s"; // The date('format') used for storing dates in MyS
    protected $_connection = false;
    public function __construct() {
        global $CONFIG;
        /* 
         * Constructor establishes the connection with the MySQL database
         */
        $this->_connection = new PDO("mysql:host=".$CONFIG["database"]["host"].";dbname=".$CONFIG["database"]["database"],
                $CONFIG["database"]["username"],$CONFIG["database"]["password"]);
    }
    
    public function __destruct() {
        /* 
         * Destructor closes the connection with teh MySQL database by clearing
         * the connection
         */
        if($this->_connection != false) {
            $this->_connection=null;
        }
    }   
    
    public function insert() {
        $var = "";
        foreach ($this->data as $key => $value) {
            $var .= $key;
            $var .= ",";
        }

        $var = substr_replace($var, "", -1);
        $var_value = "";
       
        foreach ($this->data as $key => $value) {
            $var_value .= "'";
            $var_value .= $value;
            $var_value .= "'";
            $var_value .= ",";
        }

        $var_value = substr_replace($var_value, "", -1);
        $query = "INSERT INTO " . $this->tableName . " (" . $var . ") VALUES(" . $var_value . ")";           
        $result = $this->_connection->prepare($query);        
        $result->execute();
       
        return $this->insertedId();
    }

    public function select() {
        $column = "";
        $data = array();
        if (!empty($this->columns) && is_array($this->columns) && $this->columns != false) {
            foreach ($this->columns as $key => $val) {
                $column .= $val . ",";
            }
            $column = substr($column, 0, -1);
        } else {
            $column = "*";
        }
        if ($this->where == false) {
            $this->where = " WHERE 1=1";
        }
        if ($column && $this->where) {
            $query = "select " . $column . " from " . $this->tableName . $this->where;            
            $result = $this->_connection->prepare($query);
            $result->execute();
            
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
        }

        return $data;
    }
    
    public function queryStr($query){
        $data = [];
        $result = $this->_connection->prepare($query);
            $result->execute();
            
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
    }

    public function update() {
        if (!empty($this->columns) && !empty($this->where)) {
            $data = '';
            foreach ($this->columns as $key => $val) {
                $data .= $key . "='" . $val . "',";
            }
            $column = substr($data, 0, -1);

            $query = "UPDATE " . $this->tableName . " SET " . $column . " " . $this->where;
            
            $result = $this->_connection->prepare($query);
            $result->execute();
            return true;
        }
    }

    public function delete() {
        
        if ($this->id) {
            $query = "DELETE FROM " . $this->tableName . " WHERE id = " . $this->id;
            $result = $this->_connection->prepare($query);
            $result->execute();
        }
        return true;
    }

    public function join() {
        /*
          $table: it will array key pair value, key will alias and value will table name
          $column: it will with alias of table
          $where : it will if any condition match
         */
        $column = '';
        if ($this->columns != false && !empty($this->columns)) {

            foreach ($this->columns as $key => $value) {
                $column .= $value . ", ";
            }
            $column = substr($column, 0, -2);
        } else {
            $column = "*";
        }

        if ($this->where != false) {
            $where = $this->where;
        } else {
            $where = "WHERE 1=1";
        }

        if ($this->joinTable != false && !empty($this->$joinTable)) {
            if ($this->$join != false && !empty($this->$join)) {
                foreach ($this->$joinTable as $key => $table) {
                    // from abc as a left join xyz as x on a.id = b.id left join pqr as p on a.id = p.id
                }
            }
        }
    }

    public function joinLeft() {
        $data = [];
        
        if (!empty($this->query)) {
            $result = $this->_connection->prepare($this->query);
            $result->execute();
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            
        }
        return $data;
    }

    public function countRow() {
        $query = "SELECT * FROM " . $this->tableName . $this->where;
        $result = $this->_connection->query($query);
        return $result->rowCount();
    }

    public function mysql_num_rows() {
     $result = $this->_connection->prepare($this->query);
     return $result->rowCount();
    }

    public function insertedId() {
        $insertedId = $this->_connection->lastInsertId();
        return $insertedId;
    }

    /* query parser */

//    public function queryParser($data) {
//        $result = $this->_connection->prepare($data);
//        $result->execute();
//
//        if ($result)
//            return $result;
//        else
//            return false;
//    }

    

}
