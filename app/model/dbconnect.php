<?php
//chamada das classes internas
   class dbconnect {
		
	    public  $con;
	    public  $conMSV;

	    
	    function __construct() {
	        $servidor = 'localhost';
	        $usuario = 'root';
	        $senha = '';
	        $bd = 'sgoes';
			
			$this->con = mysqli_connect($servidor, $usuario, $senha, $bd) or die(mysqli_connect_error());
			
	    }

	
	}

//chamadas das classes externas
   function condb() { 

	    $host_name = "localhost"; 
	    $database = "sgoes";
	    $username = "root";          
	    $password = "";    
		
	    $con = new mysqli($host_name, $username, $password, $database); 

	    //if connection fails, stop script execution 
	    if (mysqli_connect_errno()) { 
	        echo "Erro ao conectar com o Banco de Dados." . trigger_error(mysqli_connect_error());
	        exit(); 
	    } 
	    return $con; 
	} 

?>