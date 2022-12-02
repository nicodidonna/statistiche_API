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
	public function __construct()
		{
		$this->conn = Database::getInstance();
		}

	// READ verbali_by_articolo
	function read($dataInizio = null, $dataFine = null)
	{

		if($dataInizio != null and $dataFine != null){

			// select all
			$query = "SELECT s.TIP_STR as tipo_strada, s.DESCRIZ as nome_strada, count(b.id_bollettario) as num_verbali
			FROM $this->table_name_1 as b
			INNER JOIN $this->table_name_2 as s on b.id_stradario_verbale_bollettario = s.cod_via
			WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' and '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
			group by s.COD_VIA
			order by num_verbali desc";

		} else {

			$query = "SELECT s.TIP_STR as tipo_strada, s.DESCRIZ as nome_strada, count(b.id_bollettario) as num_verbali
			FROM $this->table_name_1 as b
			INNER JOIN $this->table_name_2 as s on b.id_stradario_verbale_bollettario = s.cod_via
			WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
			group by s.COD_VIA
			order by num_verbali desc";

		}
		
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		
		}

	}


?>