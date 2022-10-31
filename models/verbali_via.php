<?php


class VerbaliVia
	{

	private $conn;
	private $table_name = "verbali_by_via";
	// campi di verbali_by_articolo
	public $via;
    public $comune;
	public $num_verbali_via;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read()
		{
		// select all
		$query = "SELECT via, comune, num_verbali_via FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>