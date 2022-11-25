<?php


class VerbaliAttiviInattivi
	{

	private $conn;
	private $table_name = "db2_bollettario";
	// campi di verbali_by_articolo
	public $stato_verbali;
	public $num_verbali;

	// costruttore
	public function __construct()
		{
		$this->conn = Database::getInstance();
		}

	// READ verbali_by_articolo
	function read($dataInizio = null, $dataFine = null)
		{

			if($dataInizio != null and $dataFine != null) {

				// select all
				$query = "SELECT stato_archivio_verbale_bollettario as stato_verbali, count(id_bollettario) as num_verbali
				FROM $this->table_name
				WHERE data_verbale_bollettario between '$dataInizio' and '$dataFine'
				GROUP BY stato_archivio_verbale_bollettario
				ORDER BY num_verbali DESC";

			} else {

				// select all
				$query = "SELECT stato_archivio_verbale_bollettario as stato_verbali, count(id_bollettario) as num_verbali
				FROM $this->table_name
				WHERE data_verbale_bollettario <= CURDATE()
				GROUP BY stato_archivio_verbale_bollettario
				ORDER BY num_verbali DESC";

			}
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;
			
		}

	}


?>