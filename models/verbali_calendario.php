<?php


class VerbaliArticolo
	{

	private $conn;
	private $table_name_1 = "db2_infrazione";
	private $table_name_2 = "articoli_new";
	private $table_name_3 = "db2_bollettario";
	// campi di verbali_by_articolo
	public $articolo;
	public $num_verbali;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read()
		{

		//query
		$query = "SELECT a.descrizione AS articolo, 
        b.data_verbale_bollettario AS data_verbale
        FROM $this->table_name_1 AS i
        INNER JOIN $this->table_name_2 AS a ON i.Cod_Articolo_infrazione = a.id_articolo
        INNER JOIN $this->table_name_3 AS b ON i.id_bollettario_infrazione = b.id_bollettario
        ORDER BY b.data_verbale_bollettario ASC";

		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>