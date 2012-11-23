<?php
	
	
	
	class Database extends PDO
	{
		public $SLOW_QUERY_THRESHOLD= 0.1;
			
		public function __construct($hostdb,$user,$pass) 
		{
			parent::__construct($hostdb, $user, $pass);
			
			//$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );  
			//$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );  
			$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
			
			//$this->setAttribute(PDO::FETCH, PDO::FETCH_ASSOC);
			$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
			
			//$this->setAttribute(PDO::ATTR_TIMEOUT,3);
			
		}

		function getPDOConstantType( $var )
		{
			if( is_int( $var ) )
			return PDO::PARAM_INT;
		  if( is_bool( $var ) )
			return PDO::PARAM_BOOL;
		  if( is_null( $var ) )
			return PDO::PARAM_NULL;
		  //Default  
		  return PDO::PARAM_STR;
		}
		
		
		public function run($query,$bindings)
		{
			$time = microtime(TRUE);
			$sth = $this->prepare($query);
	
			//very important $value must be reference or it will bind the same value on keys
			foreach($bindings as $key=>&$value)
			{
				$sth->bindParam($key,$value);
			}

			$sth->execute();

			return $sth;
		}

	}

	
	

?>