<?php


class VerbaliAgente
	{

	private $conn;
	private $table_name = "verbali_by_agenti";
	// campi di verbali_by_articolo
	public $nome;
	public $cognome;
    public $grado;
	public $matricola;
    public $num_verbali_agente;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read()
		{
		// select all
		$query = "SELECT nome, cognome, grado, matricola, num_verbali_agente FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>