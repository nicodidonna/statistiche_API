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
	public function __construct($id)
	{
		$this->conn = Database::getInstance($id);
	}

	// READ verbali_by_articolo
	function read($tipoRead, $dataInizio = null, $dataFine = null)
	{
		
		try{
		
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
			
			if($tipoRead == 'verbali_preavvisi'){
				
				if($dataInizio != null and $dataFine != null){
					
					// select all
					$query = "SELECT tipo_strada, nome_strada, SUM(num_verbali) as num_verbali
					FROM 
					(SELECT s.TIP_STR AS tipo_strada, s.DESCRIZ AS nome_strada, count(b.id_bollettario) AS num_verbali
					FROM db2_bollettario AS b
					INNER JOIN db1_stradario AS s ON b.id_stradario_verbale_bollettario = s.cod_via
					WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
					GROUP BY s.COD_VIA
					UNION ALL
					SELECT s.TIP_STR AS tipo_strada, b.kmstrada_verbale_bollettario_pr AS nome_strada, count(b.id_bollettario_pr) AS num_verbali
					FROM db6_bollettario_pr AS b
					LEFT JOIN db1_stradario AS s ON b.id_stradario_verbale_bollettario_pr = s.cod_via
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' AND '$dataFine'  AND b.stato_archivio_verbale_bollettario_pr = 0
					GROUP BY b.kmstrada_verbale_bollettario_pr) unione
					GROUP BY nome_strada
					ORDER BY num_verbali DESC";
					
				} else {
					
					$query = "SELECT tipo_strada, nome_strada, SUM(num_verbali) as num_verbali
					FROM 
					(SELECT s.TIP_STR AS tipo_strada, s.DESCRIZ AS nome_strada, count(b.id_bollettario) AS num_verbali
					FROM db2_bollettario AS b
					INNER JOIN db1_stradario AS s ON b.id_stradario_verbale_bollettario = s.cod_via
					WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
					GROUP BY s.COD_VIA
					UNION ALL
					SELECT s.TIP_STR AS tipo_strada, b.kmstrada_verbale_bollettario_pr AS nome_strada, count(b.id_bollettario_pr) AS num_verbali
					FROM db6_bollettario_pr AS b
					LEFT JOIN db1_stradario AS s ON b.id_stradario_verbale_bollettario_pr = s.cod_via
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
					GROUP BY b.kmstrada_verbale_bollettario_pr) unione
					GROUP BY nome_strada
					ORDER BY num_verbali DESC";
					
				}
			
			}
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;
		
		} catch (PDOException $exception) {
			
			http_response_code(500);
            echo json_encode(array("message" => "Errore nella query, contattare un tecnico."));
            exit();

        }
	
	}

}


?>