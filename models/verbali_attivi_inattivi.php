<?php


class VerbaliAttiviInattivi
	{

	private $conn;
	private $table_name = "db2_bollettario";
	// campi di verbali_by_articolo
	public $stato_verbali;
	public $num_verbali;

	// costruttore
	public function __construct($id)
		{
		$this->conn = Database::getInstance($id);
		}

	// READ verbali_by_articolo
	function read($tipoRead, $dataInizio = null, $dataFine = null)
		{

			if($tipoRead == 'verbali'){

				if($dataInizio != null and $dataFine != null) {

					// select all
					$query = "SELECT b.stato_archivio_verbale_bollettario as stato_verbali, count(b.id_bollettario) as num_verbali
					FROM $this->table_name AS b
					WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' and '$dataFine'
					GROUP BY b.stato_archivio_verbale_bollettario
					ORDER BY num_verbali DESC";
	
				} else {
	
					// select all
					$query = "SELECT b.stato_archivio_verbale_bollettario as stato_verbali, count(b.id_bollettario) as num_verbali
					FROM $this->table_name AS b
					WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE()
					GROUP BY b.stato_archivio_verbale_bollettario
					ORDER BY num_verbali DESC";
	
				}
				
			}

			if($tipoRead == 'preavvisi'){

				if($dataInizio != null and $dataFine != null) {

					// select all
					$query = "SELECT b.stato_archivio_verbale_bollettario_pr as stato_verbali, count(b.id_bollettario_pr) as num_verbali
					FROM db6_bollettario_pr AS b
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' and '$dataFine'
					GROUP BY b.stato_archivio_verbale_bollettario_pr
					ORDER BY num_verbali DESC";
	
				} else {
	
					// select all
					$query = "SELECT b.stato_archivio_verbale_bollettario_pr as stato_verbali, count(b.id_bollettario_pr) as num_verbali
					FROM db6_bollettario_pr AS b
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE()
					GROUP BY b.stato_archivio_verbale_bollettario_pr
					ORDER BY num_verbali DESC";
	
				}

			}

			if($tipoRead == 'verbali_preavvisi'){

				if($dataInizio != null and $dataFine != null) {

					// select all
					$query = "SELECT stato_verbali, SUM(num_verbali) AS num_verbali
					FROM
					(SELECT b.stato_archivio_verbale_bollettario as stato_verbali, count(b.id_bollettario) as num_verbali
					FROM db2_bollettario AS b
					WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' and '$dataFine'
					GROUP BY b.stato_archivio_verbale_bollettario
					UNION ALL
					SELECT b.stato_archivio_verbale_bollettario_pr as stato_verbali, count(b.id_bollettario_pr) as num_verbali
					FROM db6_bollettario_pr AS b
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' and '$dataFine'
					GROUP BY b.stato_archivio_verbale_bollettario_pr) unione
					GROUP BY stato_verbali
					ORDER BY num_verbali DESC";
	
				} else {
	
					// select all
					$query = "SELECT stato_verbali, SUM(num_verbali) AS num_verbali
					FROM
					(SELECT b.stato_archivio_verbale_bollettario as stato_verbali, count(b.id_bollettario) as num_verbali
					FROM db2_bollettario AS b
					WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE()
					GROUP BY b.stato_archivio_verbale_bollettario
					UNION ALL
					SELECT b.stato_archivio_verbale_bollettario_pr as stato_verbali, count(b.id_bollettario_pr) as num_verbali
					FROM db6_bollettario_pr AS b
					WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE()
					GROUP BY b.stato_archivio_verbale_bollettario_pr) unione
					GROUP BY stato_verbali
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