<?php 

	class Categories{

		public $tablename = "categories";

		public function __construct(){
			$db = new DB_con();
		}


		public function getAll() {
			$result = mysql_query("SELECT * FROM $this->tablename");
			$fetchall = array();
			if($result) {
				$index = 0;
				while($row = mysql_fetch_assoc($result))
				{
				     $fetchall[$index] = $row;
				     $index++;
				}
			}

			return $fetchall;
			
		}

		public function insert($data){

			$var = "";			
			foreach($data as $key => $value) {
				 $var .= $this->escapeData($key);
				 $var .=",";
			}

			$var = substr_replace($var ,"",-1);
			$var_value = "";
			foreach($data as $key => $value) {
				 $var_value .="'";
				 $var_value .= $this->escapeData($value);
				 $var_value .="'";
				 $var_value .=",";
				
			}
           
			$var_value = substr_replace($var_value ,"",-1);
             $query= "INSERT INTO ".$this->tablename." (". $var .") VALUES(".$var_value.")";
			 $result = $this->queryParser($query);
			 return $result;
			
		}

		/*query parser*/
		public function queryParser($data){
		  $result=mysql_query($data) or die('Oops Something Wrong -> ' . mysql_error());
		  return $result;
		 }


		

	}

?>