<?php


class VerbaliSanzioneAcc
	{

	private $conn;

	// costruttore
	public function __construct($id)
		{
		$this->conn = Database::getInstance($id);
		}

	// READ verbali_by_docallegato
	function read($tipoRead, $dataVerbaleInizio = null, $dataVerbaleFine = null, $dataCreazioneInizio = null, $dataCreazioneFine = null)
		{
			if($tipoRead == 'verbali'){
				
				if( $dataVerbaleInizio != null and $dataVerbaleFine != null ){

					//query
					$query = "SELECT sa.tipo_sanzioneacc AS tipo_sanzione_accessoria, count(sa.id_sanzioneacc) AS num_verbali
                    FROM db2_sanzioneacc AS sa
                    INNER JOIN db2_bollettario AS b ON b.id_bollettario = sa.id_bollettario_sanzioneacc
                    WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataVerbaleInizio' AND '$dataVerbaleFine'
                    GROUP BY sa.tipo_sanzioneacc
					ORDER BY num_verbali DESC";
					
				} else if( $dataCreazioneInizio != null and $dataCreazioneFine != null ){

                    //query
					$query = "SELECT sa.tipo_sanzioneacc AS tipo_sanzione_accessoria, count(sa.id_sanzioneacc) AS num_verbali
                    FROM db2_sanzioneacc AS sa
                    INNER JOIN db2_bollettario AS b ON b.id_bollettario = sa.id_bollettario_sanzioneacc
                    WHERE CAST(sa.created_at_sanzioneacc AS DATE) BETWEEN '$dataCreazioneInizio' AND '$dataCreazioneFine'
                    GROUP BY sa.tipo_sanzioneacc
					ORDER BY num_verbali DESC";

                } else {

					//query
					$query = "SELECT sa.tipo_sanzioneacc AS tipo_sanzione_accessoria, count(sa.id_sanzioneacc) AS num_verbali
                    FROM db2_sanzioneacc AS sa
                    INNER JOIN db2_bollettario AS b ON b.id_bollettario = sa.id_bollettario_sanzioneacc
                    WHERE CAST(b.data_verbale_bollettario AS DATE) <=CURDATE() AND CAST(sa.created_at_sanzioneacc AS DATE) <=CURDATE()
                    GROUP BY sa.tipo_sanzioneacc
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