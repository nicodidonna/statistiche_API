<?php
class Database
	{
	// credenziali
	private $host = "localhost";
	private $db_name = "sanzioni_rutigliano";
	private $username = "root";
	private $password = "";
	public $conn;

	// connessione al database
	public function getConnection()
		{
		$this->conn = null;

		try
			{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		catch(PDOException $exception)
			{
			echo "Errore di connessione: " . $exception->getMessage();
			}
		return $this->conn;
		}

	}


?>