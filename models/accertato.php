<?php


class Accertato
	{

	private $conn;
	private $table_name_1 = "db2_bollettario";
	private $table_name_2 = "db6_bollettario_pr";

	// costruttore
	public function __construct()
		{
		$this->conn = Database::getInstance();
		}


    //query accertato verbali    
	function read($tipoRead)
		{

            if($tipoRead == 'verbali'){

                //query
                $query = "SELECT a.Imp_Ridotto_60gg_euro, b.spese_notifica_verbale_bollettario, b.spese_stampa_verbale_bollettario , b.tipo_bollettario
                FROM $this->table_name_1 as b
                INNER JOIN db2_infrazione as i on i.id_bollettario_infrazione = b.id_bollettario
                INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione
                WHERE b.stato_archivio_verbale_bollettario = 0 AND a.Imp_Ridotto_60gg IS NOT NULL AND a.Imp_Ridotto_60gg_euro IS NOT NULL";

            }

            if($tipoRead == 'preavvisi'){

                //query
                $query = "SELECT a.Imp_Ridotto_60gg_euro
                FROM $this->table_name_2 as b
                INNER JOIN db2_infrazione as i on i.id_bollettario_infrazione = b.id_bollettario_pr
                INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione
                WHERE b.stato_archivio_verbale_bollettario_pr = 0 AND a.Imp_Ridotto_60gg IS NOT NULL AND a.Imp_Ridotto_60gg_euro IS NOT NULL; ";

            }
            
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;

		}

	}


?>