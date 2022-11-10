<?php


class ListaArticoli
	{

	private $conn;
	private $table_name = "articoli_new";
	// campi di verbali_by_articolo
	public $stato_verbali;
	public $num_verbali;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read()
		{
		// select all
		$query = "SELECT DISTINCT a.descrizione AS articolo
        FROM $this->table_name AS a";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>