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
	function read($tipoRead)
		{

            if($tipoRead == 'verbali'){

                //query
                $query = "SELECT importo_pagamento_verbale_bollettario, spese_notifica_verbale_bollettario, spese_stampa_verbale_bollettario
                FROM $this->table_name_1
                WHERE data_pagamento_verbale_bollettario IS NOT NULL AND stato_archivio_verbale_bollettario = 0";

            }

            if($tipoRead == 'preavvisi'){

                //query
                $query = "SELECT importo_pagamento_verbale_bollettario_pr, spese_notifica_verbale_bollettario_pr, spese_stampa_verbale_bollettario_pr
                FROM $this->table_name_2
                WHERE data_pagamento_verbale_bollettario_pr IS NOT NULL AND stato_archivio_verbale_bollettario_pr = 0";

            }
            
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;

		}

	}


?>