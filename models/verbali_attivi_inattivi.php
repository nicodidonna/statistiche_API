<?php


class VerbaliAttiviInattivi
	{

	private $conn;
	private $table_name = "verbali_attivi_inattivi";
	// campi di verbali_by_articolo
	public $tipo_verbali;
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
		$query = "SELECT tipo_verbali, num_verbali FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>