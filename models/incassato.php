<?php


class Incassato
	{

	private $conn;
	private $table_name_1 = "db2_bollettario";
	private $table_name_2 = "db6_bollettario_pr";

	// costruttore
	public function __construct()
		{
		$this->conn = Database::getInstance();
		}


    //query incassato verbali    
	function read($tipoRead, $dataInizio = null, $dataFine = null)
		{

            if($tipoRead == 'verbali'){

				if ($dataInizio != null and $dataFine != null) {

					//query
					$query = "SELECT b.importo_pagamento_verbale_bollettario, b.spese_notifica_verbale_bollettario, b.spese_stampa_verbale_bollettario
					FROM db2_bollettario AS b
					WHERE b.data_pagamento_verbale_bollettario IS NOT NULL AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'; ";

				} else {

					//query
					$query = "SELECT b.importo_pagamento_verbale_bollettario, b.spese_notifica_verbale_bollettario, b.spese_stampa_verbale_bollettario
					FROM db2_bollettario AS b
					WHERE b.data_pagamento_verbale_bollettario IS NOT NULL AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) <= CURDATE(); ";

				}

            }

            if($tipoRead == 'preavvisi'){

				if ($dataInizio != null and $dataFine != null) {

					//query
					$query = "SELECT b.importo_pagamento_verbale_bollettario_pr, b.spese_notifica_verbale_bollettario_pr, b.spese_stampa_verbale_bollettario_pr
					FROM $this->table_name_2 AS b
					WHERE b.data_pagamento_verbale_bollettario_pr IS NOT NULL AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine'; ";

				} else {

					//query
					$query = "SELECT b.importo_pagamento_verbale_bollettario_pr, b.spese_notifica_verbale_bollettario_pr, b.spese_stampa_verbale_bollettario_pr
					FROM $this->table_name_2 AS b
					WHERE b.data_pagamento_verbale_bollettario_pr IS NOT NULL AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE(); ";

				}

            }
            
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;

		}

	}


?>