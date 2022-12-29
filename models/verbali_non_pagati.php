<?php


class VerbaliNonPagati
{

    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }

    // READ verbali_non_pagati
    function read($statoVerbale ,$tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 1 AND b.data_pagamento_verbale_bollettario IS NULL AND b.stato_archivio_verbale_bollettario = 0 AND b.stato_bollettario LIKE '$statoVerbale' AND CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'
                ORDER BY b.data_verbale_bollettario ";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 1 AND b.data_pagamento_verbale_bollettario IS NULL AND b.stato_archivio_verbale_bollettario = 0 AND b.stato_bollettario LIKE '$statoVerbale' AND CAST(b.data_verbale_bollettario AS DATE) <=CURDATE()
                ORDER BY b.data_verbale_bollettario ";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 1 AND b.data_pagamento_verbale_bollettario_pr IS NULL AND b.stato_archivio_verbale_bollettario_pr = 0 AND b.stato_bollettario_pr LIKE '$statoVerbale' AND CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' 
                ORDER BY b.data_verbale_bollettario_pr ";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 1 AND b.data_pagamento_verbale_bollettario_pr IS NULL AND b.stato_archivio_verbale_bollettario_pr = 0 AND b.stato_bollettario_pr LIKE '$statoVerbale' AND CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE()
                ORDER BY b.data_verbale_bollettario_pr ";
                
            }

        }
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    
    }

}


?>