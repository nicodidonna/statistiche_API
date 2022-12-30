<?php


class VerbaliRateizzato
{

    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }

    // READ verbali_rateizzato
    function read($tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
                FROM db2_bollettario AS b
                INNER JOIN db2_infrazione AS i ON b.id_bollettario = i.id_bollettario_infrazione
                INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione = a.id_articolo
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0 AND b.stato_bollettario = 8
                ORDER BY b.data_verbale_bollettario DESC";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
                FROM db2_bollettario AS b
                INNER JOIN db2_infrazione AS i ON b.id_bollettario = i.id_bollettario_infrazione
                INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione = a.id_articolo
                WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0 AND b.stato_bollettario = 8
                ORDER BY b.data_verbale_bollettario DESC";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
                FROM db6_bollettario_pr AS b
                INNER JOIN db6_infrazione_pr AS i ON b.id_bollettario_pr = i.id_bollettario_infrazione_pr
                INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione_pr = a.id_articolo
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0 AND b.stato_bollettario_pr = 8
                ORDER BY b.data_verbale_bollettario_pr DESC";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale, a.Descrizione AS articolo
                FROM db6_bollettario_pr AS b
                INNER JOIN db6_infrazione_pr AS i ON b.id_bollettario_pr = i.id_bollettario_infrazione_pr
                INNER JOIN articoli_new AS a ON i.Cod_Articolo_infrazione_pr = a.id_articolo
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0 AND b.stato_bollettario_pr = 8
                ORDER BY b.data_verbale_bollettario_pr DESC";
                
            }

        }
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    
    }

}


?>