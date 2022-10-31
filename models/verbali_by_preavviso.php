<?php


class VerbaliPreavviso
	{

	private $conn;
	private $table_name = "verbali_by_preavviso";
	// campi di verbali_by_articolo
	public $cronologico;
	public $numero_verbale;
    public $data;
	public $articolo;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read()
		{
		// select all
		$query = "SELECT cronologico, numero_verbale, data, articolo FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>