<?php


class VerbaliAttiviInattivi
	{

	private $conn;
	private $table_name = "db2_bollettario";
	// campi di verbali_by_articolo
	public $stato_verbali;
	public $num_verbali;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read($param, $param2)
		{
		// select all
		$query = "SELECT stato_archivio_verbale_bollettario as stato_verbali, count(id_bollettario) as num_verbali
		FROM $this->table_name
		WHERE data_verbale_bollettario between '$param' and '$param2'
		GROUP BY stato_archivio_verbale_bollettario
		ORDER BY num_verbali DESC";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>