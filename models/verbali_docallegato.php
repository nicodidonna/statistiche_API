<?php


class VerbaliDocAllegato
	{

	private $conn;

	// costruttore
	public function __construct($id)
		{
		$this->conn = Database::getInstance($id);
		}

	// READ verbali_by_docallegato
	function read($tipoRead, $dataVerbaleInizio = null, $dataVerbaleFine = null, $dataInserimentoInizio = null, $dataInserimentoFine = null)
		{
			if($tipoRead == 'verbali'){
				
				if( ($dataVerbaleInizio != null and $dataVerbaleFine != null) || ($dataInserimentoInizio != null and $dataInserimentoFine != null) ){
				
					//query
					$query = "SELECT da.tipo_docallegato AS tipo_documento_allegato, count(da.id_docallegato) AS num_verbali
                    FROM db2_docallegato as da
                    INNER JOIN db2_bollettario AS b ON da.id_bollettario_docallegato = b.id_bollettario
                    WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataVerbaleInizio' AND '$dataVerbaleFine' AND CAST(da.data_inserimento_docallegato AS DATE) BETWEEN '$dataInserimentoInizio' AND '$dataInserimentoFine'
                    GROUP BY da.tipo_docallegato";
					
				} else {
					
					//query
					$query = "SELECT da.tipo_docallegato AS tipo_documento_allegato, count(da.id_docallegato) AS num_verbali
                    FROM db2_docallegato as da
                    INNER JOIN db2_bollettario AS b ON da.id_bollettario_docallegato = b.id_bollettario
                    WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND CAST(da.data_inserimento_docallegato AS DATE) <=CURDATE()
                    GROUP BY da.tipo_docallegato";
					
				}
			
			}

			if($tipoRead == 'preavvisi'){
				
				if(($dataVerbaleInizio != null and $dataVerbaleFine != null) || ($dataInserimentoInizio != null and $dataInserimentoFine != null)){
				
					//query
					$query = "SELECT da.tipo_docallegato_pr AS tipo_documento_allegato, count(da.id_docallegato_pr) AS num_verbali
                    FROM db6_docallegato_pr as da
                    INNER JOIN db6_bollettario_pr AS b ON da.id_bollettario_pr_docallegato_pr = b.id_bollettario_pr
                    WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataVerbaleInizio' AND '$dataVerbaleFine' AND CAST(da.data_inserimento_docallegato_pr AS DATE) BETWEEN '$dataInserimentoInizio' AND '$dataInserimentoFine'
                    GROUP BY da.tipo_docallegato_pr";
					
				} else {
					
					//query
					$query = "SELECT da.tipo_docallegato_pr AS tipo_documento_allegato, count(da.id_docallegato_pr) AS num_verbali
                    FROM db6_docallegato_pr as da
                    INNER JOIN db6_bollettario_pr AS b ON da.id_bollettario_pr_docallegato_pr = b.id_bollettario_pr
                    WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND CAST(da.data_inserimento_docallegato_pr AS DATE) <=CURDATE()
                    GROUP BY da.tipo_docallegato_pr";
					
				}
			
			}

			if($tipoRead == 'verbali_preavvisi'){
				
				if(($dataVerbaleInizio != null and $dataVerbaleFine != null) || ($dataInserimentoInizio != null and $dataInserimentoFine != null)){
				
					//query
					$query = "SELECT tipo_documento_allegato, SUM(num_verbali) AS num_verbali
                    FROM
                    (SELECT da.tipo_docallegato AS tipo_documento_allegato, count(da.id_docallegato) AS num_verbali
                    FROM db2_docallegato as da
                    INNER JOIN db2_bollettario AS b ON da.id_bollettario_docallegato = b.id_bollettario
                    WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataVerbaleInizio' AND '$dataVerbaleFine' AND CAST(da.data_inserimento_docallegato AS DATE) BETWEEN '$dataInserimentoInizio' AND '$dataInserimentoFine'
                    GROUP BY da.tipo_docallegato
                    UNION ALL
                    SELECT da.tipo_docallegato_pr AS tipo_documento_allegato, count(da.id_docallegato_pr) AS num_verbali
                    FROM db6_docallegato_pr as da
                    INNER JOIN db6_bollettario_pr AS b ON da.id_bollettario_pr_docallegato_pr = b.id_bollettario_pr
                    WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataVerbaleInizio' AND '$dataVerbaleFine' AND CAST(da.data_inserimento_docallegato_pr AS DATE) BETWEEN '$dataInserimentoInizio' AND '$dataInserimentoFine'
                    GROUP BY da.tipo_docallegato_pr) unione
                    GROUP BY tipo_documento_allegato
                    ORDER BY num_verbali DESC";
					
				} else {
					
					//query
					$query = "SELECT tipo_documento_allegato, SUM(num_verbali) AS num_verbali
                    FROM
                    (SELECT da.tipo_docallegato AS tipo_documento_allegato, count(da.id_docallegato) AS num_verbali
                    FROM db2_docallegato as da
                    INNER JOIN db2_bollettario AS b ON da.id_bollettario_docallegato = b.id_bollettario
                    WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND CAST(da.data_inserimento_docallegato AS DATE) <=CURDATE()
                    GROUP BY da.tipo_docallegato
                    UNION ALL
                    SELECT da.tipo_docallegato_pr AS tipo_documento_allegato, count(da.id_docallegato_pr) AS num_verbali
                    FROM db6_docallegato_pr as da
                    INNER JOIN db6_bollettario_pr AS b ON da.id_bollettario_pr_docallegato_pr = b.id_bollettario_pr
                    WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND CAST(da.data_inserimento_docallegato_pr AS DATE) <=CURDATE()
                    GROUP BY da.tipo_docallegato_pr) unione
                    GROUP BY tipo_documento_allegato
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