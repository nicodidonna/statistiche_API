<?php


class VerbaliAgente
	{

	private $conn;
	private $table_name_1 = "db2_bollettario";
	private $table_name_2 = "db1_agente";
	// campi di verbali_by_articolo
	public $nome_agente;
	public $cognome_agente;
    public $grado_agente;
	public $matricola_agente;
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
		$query = "SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(id_bollettario) as num_verbali
		FROM $this->table_name_1 AS b
		INNER JOIN $this->table_name_2 AS a ON b.id_agente_assegn_bollettario = a.id_agente
		GROUP BY a.matricola_agente
		ORDER BY num_verbali DESC";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>