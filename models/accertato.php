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
	function read($tipoRead, $dataInizio = null, $dataFine = null)
		{

            if($tipoRead == 'verbali'){

                if ($dataInizio != null and $dataFine != null) {

                    //query
                    $query = "SELECT istat.Imp_Ridotto_60gg_euro as importo_istat2021, istat2.Imp_Ridotto_60gg_euro as importo_istat2019, istat3.Imp_Ridotto_60gg_euro as importo_istat2018, b.spese_notifica_verbale_bollettario, b.spese_stampa_verbale_bollettario , b.tipo_bollettario, DATE(b.data_verbale_bollettario) AS data_verbale_bollettario
                    FROM db2_bollettario as b
                    INNER JOIN db2_infrazione as i on i.id_bollettario_infrazione = b.id_bollettario
                    INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione
                    LEFT JOIN istat2021 as istat on istat.id_articolo = a.id_articolo
                    LEFT JOIN istat2019 as istat2 on istat2.id_articolo = a.id_articolo
                    LEFT JOIN istat2018 as istat3 on istat3.id_articolo = a.id_articolo
                    WHERE b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'; ";

                } else {

                    //query
                    $query = "SELECT istat.Imp_Ridotto_60gg_euro as importo_istat2021, istat2.Imp_Ridotto_60gg_euro as importo_istat2019, istat3.Imp_Ridotto_60gg_euro as importo_istat2018, b.spese_notifica_verbale_bollettario, b.spese_stampa_verbale_bollettario , b.tipo_bollettario, DATE(b.data_verbale_bollettario) AS data_verbale_bollettario
                    FROM db2_bollettario as b
                    INNER JOIN db2_infrazione as i on i.id_bollettario_infrazione = b.id_bollettario
                    INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione
                    LEFT JOIN istat2021 as istat on istat.id_articolo = a.id_articolo
                    LEFT JOIN istat2019 as istat2 on istat2.id_articolo = a.id_articolo
                    LEFT JOIN istat2018 as istat3 on istat3.id_articolo = a.id_articolo
                    WHERE b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) <= CURDATE();";

                }

            }

            if($tipoRead == 'preavvisi'){

                if($dataInizio != null and $dataFine != null){

                    //query
                    $query = "SELECT istat.Imp_Ridotto_60gg_euro as importo_istat2021, istat2.Imp_Ridotto_60gg_euro as importo_istat2019, istat3.Imp_Ridotto_60gg_euro as importo_istat2018, b.tipo_bollettario_pr, DATE(b.data_verbale_bollettario_pr) AS data_preavviso_bollettario
                    FROM db6_bollettario_pr as b
                    INNER JOIN db6_infrazione_pr as i on i.id_bollettario_infrazione_pr = b.id_bollettario_pr
                    INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione_pr
                    LEFT JOIN istat2021 as istat on istat.id_articolo = a.id_articolo
                    LEFT JOIN istat2019 as istat2 on istat2.id_articolo = a.id_articolo
                    LEFT JOIN istat2018 as istat3 on istat3.id_articolo = a.id_articolo
                    WHERE b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' ";

                } else {

                    //query
                    $query = "SELECT istat.Imp_Ridotto_60gg_euro as importo_istat2021, istat2.Imp_Ridotto_60gg_euro as importo_istat2019, istat3.Imp_Ridotto_60gg_euro as importo_istat2018, b.tipo_bollettario_pr, DATE(b.data_verbale_bollettario_pr) AS data_preavviso_bollettario
                    FROM db6_bollettario_pr as b
                    INNER JOIN db6_infrazione_pr as i on i.id_bollettario_infrazione_pr = b.id_bollettario_pr
                    INNER JOIN articoli_new as a on a.id_articolo = i.Cod_Articolo_infrazione_pr
                    LEFT JOIN istat2021 as istat on istat.id_articolo = a.id_articolo
                    LEFT JOIN istat2019 as istat2 on istat2.id_articolo = a.id_articolo
                    LEFT JOIN istat2018 as istat3 on istat3.id_articolo = a.id_articolo
                    WHERE b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE(); ";

                }

                

            }
            
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;

		}

	}


?>