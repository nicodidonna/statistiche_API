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
	function read($tipoRead, $dataInizio = null, $dataFine = null)
	{

		if($tipoRead == 'verbali'){

			if($dataInizio != null and $dataFine != null){

				// select all
				$query = "SELECT s.TIP_STR AS tipo_strada, s.DESCRIZ AS nome_strada, count(b.id_bollettario) AS num_verbali
				FROM $this->table_name_1 AS b
				INNER JOIN $this->table_name_2 AS s ON b.id_stradario_verbale_bollettario = s.cod_via
				WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
				GROUP BY s.COD_VIA
				ORDER BY num_verbali DESC";
	
			} else {
	
				$query = "SELECT s.TIP_STR AS tipo_strada, s.DESCRIZ AS nome_strada, count(b.id_bollettario) AS num_verbali
				FROM $this->table_name_1 AS b
				INNER JOIN $this->table_name_2 AS s ON b.id_stradario_verbale_bollettario = s.cod_via
				WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
				GROUP BY s.COD_VIA
				ORDER BY num_verbali DESC";
	
			}

		}


		if($tipoRead == 'preavvisi'){

			if($dataInizio != null and $dataFine != null){

				// select all
				$query = "SELECT count(b.id_bollettario_pr) AS num_verbali, b.kmstrada_verbale_bollettario_pr AS nome_strada
				FROM db6_bollettario_pr AS b
				WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' and '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0
				GROUP BY b.kmstrada_verbale_bollettario_pr
				ORDER BY num_verbali DESC";
	
			} else {
	
				$query = "SELECT count(b.id_bollettario_pr) AS num_verbali, b.kmstrada_verbale_bollettario_pr AS nome_strada
				FROM db6_bollettario_pr AS b
				WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
				GROUP BY b.kmstrada_verbale_bollettario_pr
				ORDER BY num_verbali DESC";
	
			}
			
		}
		
		
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		
		}

	}


?>