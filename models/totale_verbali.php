<?php


class TotaleVerbali
	{

	private $conn;
	private $table_name_1 = "db2_infrazione";
	private $table_name_2 = "articoli_new";
	private $table_name_3 = "db2_bollettario";
	// campi di verbali_by_articolo
	public $articolo;
	public $num_verbali;

	// costruttore
	public function __construct($id)
		{
		$this->conn = Database::getInstance($id);
		}

	// READ verbali_by_articolo
	function read($dataInizio = null, $dataFine = null)
		{
			if ($dataInizio != null and $dataFine != null){

				//query con filtri
				$query = "SELECT count(i.id_infrazione) as num_verbali, CAST(b.data_verbale_bollettario AS date) as data_verbali
				FROM $this->table_name_1 as i
				INNER JOIN $this->table_name_2 as a on i.Cod_Articolo_infrazione = a.id_articolo
				INNER JOIN $this->table_name_3 as b on i.id_bollettario_infrazione = b.id_bollettario
				WHERE DATE(b.data_verbale_bollettario) between '$dataInizio' and '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
				GROUP BY data_verbali
				ORDER BY data_verbali ASC";

			} else {

				//query senza filtri
				$query = "SELECT count(i.id_infrazione) as num_verbali, CAST(b.data_verbale_bollettario AS date) as data_verbali
				FROM $this->table_name_1 as i
				INNER JOIN $this->table_name_2 as a on i.Cod_Articolo_infrazione = a.id_articolo
				INNER JOIN $this->table_name_3 as b on i.id_bollettario_infrazione = b.id_bollettario
				WHERE DATE(b.data_verbale_bollettario) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
				GROUP BY data_verbali
				ORDER BY data_verbali ASC";

			}
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;
		
		}

	}


?>