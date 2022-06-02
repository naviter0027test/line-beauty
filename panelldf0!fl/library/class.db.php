<?php
class DB{

    //protected $dbHost     = "localhost";
    //protected $dbUsername = "linebeauty";
    //protected $dbPassword = "6eYrPW8CpBZTcsZW";
    protected $dbHost     = "192.168.3.40";
    protected $dbUsername = "projer";
    protected $dbPassword = "4vgh_0ad";
    protected $dbName     = "linebeauty";

    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
				$conn ->exec("set names utf8");
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }
    
	/*
     * Check table is exist
     */
	
	 public function showtable($table){
		 $sql = 'SHOW TABLES LIKE "'.$table.'"';
		 $query = $this->db->prepare($sql);
         $query->execute();
		 
	}
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
        public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
		//used for Left Join
		if(array_key_exists("on",$conditions)){
            $sql .= ' ON '.$conditions['on']; 
        }
		
		//USED FOR WHERE
        if(array_key_exists("where",$conditions)){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
		//USED FOR WHEREOR
       if(array_key_exists("where_or", $conditions) && !empty($conditions['where_or'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $whereorSQL = '';
            foreach($conditions['where_or'] as $key => $value){
                $pre = ($i > 0)?' OR ':'';
                $whereorSQL .= $pre.$key." = '".$value."'";				
                $i++;
            }
            $sql .= '('.$whereorSQL.')';
        }
		//USED FOR !=WHERE
		if(array_key_exists("notwhere", $conditions) && !empty($conditions['notwhere'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $notwhereSQL = '';
            foreach($conditions['notwhere'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $notwhereSQL .= $pre.$key." != '".$value."'";
                $i++;
            }
            $sql .= '('.$notwhereSQL.')';
        }
		//3 USED FOR IN
       if(array_key_exists("in", $conditions) && !empty($conditions['in'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $inSQL = '';
            foreach($conditions['in'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $inSQL .= $pre.$key." IN (".$value.")";
                $i++;
            }
            $sql .= '('.$inSQL.')';
        }
	
		
		//REGEXP
		if(array_key_exists("regexp", $conditions) && !empty($conditions['regexp'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $regexpSQL = '';
            foreach($conditions['regexp'] as $key => $value){
                $pre = ($i > 0)?' OR ':'';
                 $regexpSQL .= $pre.$key." REGEXP '".$value."'";
                $i++;
            }
            $sql .= '('.$regexpSQL.')';
        }
        //used for LIKE
		if(array_key_exists("like", $conditions) && !empty($conditions['like'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $likeSQL = '';
            foreach($conditions['like'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $likeSQL .= $pre.$key." LIKE '%".$value."%'";
                $i++;
            }
            $sql .= '('.$likeSQL.')';
        }
		
		 if(array_key_exists("like_or", $conditions) && !empty($conditions['like_or'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $likeSQL = '';
            foreach($conditions['like_or'] as $key => $value){
                $pre = ($i > 0)?' OR ':'';
                $likeSQL .= $pre.$key." LIKE '%".$value."%'";
                $i++;
            }
            $sql .= '('.$likeSQL.')';
        }
		//used for ORDER BY
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
        //used for LIMIT
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }else if(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
        
        $query = $this->db->prepare($sql);
        $query->execute();
		
        //used for QUERY TYPE
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }
        return !empty($data)?$data:false;
    }
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val){
				
				//bind加上PARAM寫法
				if(is_int($val))        { $param = PDO::PARAM_INT; }
				else if(is_bool($val))   { $param = PDO::PARAM_BOOL; }
				else if(is_null($val))   { $param = PDO::PARAM_NULL; }
				else if(is_string($val)) { $param = PDO::PARAM_STR; }
				else { $param = FALSE;}
					
				if($param){
					$query->bindValue(':'.$key, $val ,$param);
				}else{
					$query->bindValue(':'.$key, $val);
				}
               // $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            return $insert?$this->db->lastInsertId():false;
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
			$columnSet = '';
            $whereSql = '';
            $i = 0;
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
			
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
				  $columnSet.= $pre.$key."=:".$key;
                $i++;
            }
			
			
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
			
            $sql = "UPDATE ".$table." SET ".$columnSet.$whereSql;
            $query = $this->db->prepare($sql);
			
			foreach($data as $key=>$val){
				//bind加上PARAM寫法
				if(is_int($val))        { $param = PDO::PARAM_INT; }
				else if(is_bool($val))   { $param = PDO::PARAM_BOOL; }
				else if(is_null($val))   { $param = PDO::PARAM_NULL; }
				else if(is_string($val)) { $param = PDO::PARAM_STR; }
				else { $param = FALSE;}
					
				if($param){
					$query->bindValue(':'.$key, $val ,$param);
				}else{
					$query->bindValue(':'.$key, $val);
				}
				
           }
			
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." =:".$key;
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
		$query = $this->db->prepare($sql);
		

   		if(!empty($conditions)&& is_array($conditions)){
            foreach($conditions as $key => $value){
				//bind加上PARAM寫法
				if(is_int($value))        { $param = PDO::PARAM_INT; }
				else if(is_bool($value))   { $param = PDO::PARAM_BOOL; }
				else if(is_null($value))   { $param = PDO::PARAM_NULL; }
				else if(is_string($value)) { $param = PDO::PARAM_STR; }
				else { $param = FALSE;}
					
				if($param){
					$query->bindValue(':'.$key, $value ,$param);
				}else{
					$query->bindValue(':'.$key, $value);
				}
				//
				
            }
        }

		
		$delete = $query->execute();
        return $delete?$delete:false;
    }
}
