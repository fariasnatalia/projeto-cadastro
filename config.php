<?php
	$dbHost = getenv('DB_HOST')? getenv('DB_HOST'): 'Localhost';
	$dbUsername = getenv('DB_USERNAME')? getenv('DB_USERNAME'): 'root';
	$dbPassword = getenv('DB_PASSWORD')? getenv('DB_PASSWORD'): '';
	$dbName = getenv('DB_NAME')? getenv('DB_NAME'): 'test';
	$dbPort = getenv('DB_PORT')? getenv('DB_PORT'): null;

	$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

	$criaTabelaUsuario = "CREATE TABLE IF NOT EXISTS usuarios (
		id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
		nome varchar(100) NOT NULL,
		email varchar(100) NOT NULL,
		senha varchar(100) NOT NULL
	)
	ENGINE=InnoDB
	DEFAULT CHARSET=latin1
	COLLATE=latin1_swedish_ci;";

	if($conexao->connect_error){
		echo "Ocorreu um erro com a conexão com o banco de dados.";
	}else{   
		mysqli_query($conexao, $criaTabelaUsuario);
	}
?>