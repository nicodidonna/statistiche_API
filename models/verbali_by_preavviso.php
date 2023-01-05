<?php


class VerbaliPreavviso
{
	
	private $conn;
	// campi di verbali_by_articolo
	public $cronologico;
	public $numero_verbale;
    public $data_verbale;
	public $articolo;
	public $anno_verbale;

	// costruttore
	public function __construct($id)
	{
		$this->conn = Database::getInstance($id);
	}

	// READ verbali_by_preavviso
	function read($dataInizio = null, $dataFine = null)
	{
		
		try{
			
			// select all
			if ($dataInizio != null and $dataFine != null) {
				
				$query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
				FROM db2_bollettario AS b
				INNER JOIN db2_infrazione AS i ON b.id_bollettario = i.id_bollettario_infrazione
				INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione = a.id_articolo
				WHERE b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' and '$dataFine' 
				ORDER BY b.data_verbale_bollettario DESC";
				
			} else {
				
				$query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
				FROM db2_bollettario AS b
				INNER JOIN db2_infrazione AS i ON b.id_bollettario = i.id_bollettario_infrazione
				INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione = a.id_articolo
				WHERE b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() 
				ORDER BY b.data_verbale_bollettario DESC";
				
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