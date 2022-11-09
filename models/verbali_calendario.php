<?php


class VerbaliCalendario
	{

	private $conn;
	private $table_name_1 = "db2_infrazione";
	private $table_name_2 = "articoli_new";
	private $table_name_3 = "db2_bollettario";
	private $table_name_4 = "db1_agente";
	// campi di verbali_by_articolo
	public $articolo;
	public $num_verbali;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read($param)
		{

			if($param == 'undefined'){
				//query
				$query = "SELECT a.descrizione AS articolo, b.data_verbale_bollettario AS data_verbale, ag.nome_agente, ag.cognome_agente, b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario as anno_verbale
				FROM $this->table_name_1 AS i
				INNER JOIN $this->table_name_2 AS a ON i.Cod_Articolo_infrazione = a.id_articolo
				INNER JOIN $this->table_name_3 AS b ON i.id_bollettario_infrazione = b.id_bollettario
				INNER JOIN $this->table_name_4 AS ag ON b.id_agente_assegn_bollettario = ag.id_agente
				ORDER BY b.data_verbale_bollettario ASC;";
			}else{
				//query
				$query = "SELECT a.descrizione AS articolo, b.data_verbale_bollettario AS data_verbale, ag.nome_agente, ag.cognome_agente, b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario as anno_verbale
				FROM $this->table_name_1 AS i
				INNER JOIN $this->table_name_2 AS a ON i.Cod_Articolo_infrazione = a.id_articolo
				INNER JOIN $this->table_name_3 AS b ON i.id_bollettario_infrazione = b.id_bollettario
				INNER JOIN $this->table_name_4 AS ag ON b.id_agente_assegn_bollettario = ag.id_agente
				WHERE a.descrizione = '$param'
				ORDER BY b.data_verbale_bollettario ASC;";
			}

		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>