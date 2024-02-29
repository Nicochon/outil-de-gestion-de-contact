<?php
class DBConnect
{
	public function __construct()
	{
		$this->connectBDD();
	}

	public function connectBDD()
	{
		try {
			$this->contactsBDD = new PDO('mysql:host=projet_5_Php_db;dbname=Projet5;charset=utf8mb4', 'root', 'root');
		} catch (Exception $e) {
			die('Erreur: ' . $e->getMessage());
		}
	}
}
?>