<?php
	
	function getConexao(){

		
		try {

			$host="mysql:host=localhost;dbname=chat;charset=utf8";
			$user="root";
			$senha= "";

			$pdo = new PDO($host, $user, $senha);
			
			return $pdo;
		} catch (Exception $e) {
			echo "Erro de Conexão: ".$e->getMessage();
		}
		}
	





?>