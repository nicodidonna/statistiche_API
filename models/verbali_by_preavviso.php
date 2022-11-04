<?php


class VerbaliPreavviso
	{

	private $conn;
	private $table_name_1 = "db2_bollettario";
	private $table_name_2 = "db2_infrazione";
	private $table_name_3 = "articoli_new";
	// campi di verbali_by_articolo
	public $cronologico;
	public $numero_verbale;
    public $data_verbale;
	public $articolo;
	public $anno_verbale;

	// costruttore
	public function __construct($db)
		{
		$this->conn = $db;
		}

	// READ verbali_by_articolo
	function read($param, $param2)
		{
		// select all
		$query = "SELECT b.num_ordine_bollettario as cronologico, b.numero_bollettario as numero_verbale, b.anno_bollettario as anno_verbale, CAST(data_verbale_bollettario AS date) as data_verbale, a.Descrizione as articolo
		FROM $this->table_name_1 as b
		INNER JOIN $this->table_name_2 as i on b.id_bollettario = i.id_bollettario_infrazione
		INNER JOIN $this->table_name_3 as a on i.Cod_Articolo_infrazione = a.id_articolo
		WHERE b.data_verbale_bollettario between '$param' and '$param2'
		ORDER BY data_verbale DESC";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>