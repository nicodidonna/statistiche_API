<?php


class VerbaliVia
	{

	private $conn;
	private $table_name_1 = "db2_bollettario";
	private $table_name_2 = "db1_stradario";
	// campi di verbali_by_articolo
	public $tipo_strada;
    public $nome_strada;
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
		$query = "SELECT s.TIP_STR as tipo_strada, s.DESCRIZ as nome_strada, count(b.id_bollettario) as num_verbali
		FROM $this->table_name_1 as b
		INNER JOIN $this->table_name_2 as s on b.id_stradario_verbale_bollettario = s.cod_via
		group by s.COD_VIA
		order by num_verbali desc";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		}

	}


?>