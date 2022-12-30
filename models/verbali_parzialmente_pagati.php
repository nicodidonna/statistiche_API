<?php


class VerbaliParzialmentePagati
{

    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }

    // READ verbali_parzialmente_pagati
    function read($tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, b.importo_pagamento_verbale_bollettario AS importo_pagato, b.importotot_pagamento_verbale_bollettario AS tot_pagamento, b.spese_notifica_verbale_bollettario AS spese_notifica, b.spese_stampa_verbale_bollettario AS spese_stampa, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, DATE_FORMAT(b.data_notifica_verbale_bollettario,'%d/%m/%Y') AS data_notifica, DATE_FORMAT(b.data_pagamento_verbale_bollettario,'%d/%m/%Y') AS data_pagamento
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 1 AND b.data_pagamento_verbale_bollettario IS NOT NULL AND b.stato_bollettario != 8 AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine' 
                ORDER BY b.data_verbale_bollettario DESC";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, b.importo_pagamento_verbale_bollettario AS importo_pagato, b.importotot_pagamento_verbale_bollettario AS tot_pagamento, b.spese_notifica_verbale_bollettario AS spese_notifica, b.spese_stampa_verbale_bollettario AS spese_stampa, DATE_FORMAT(b.data_verbale_bollettario,'%d/%m/%Y') AS data_verbale, DATE_FORMAT(b.data_notifica_verbale_bollettario,'%d/%m/%Y') AS data_notifica, DATE_FORMAT(b.data_pagamento_verbale_bollettario,'%d/%m/%Y') AS data_pagamento
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 1 AND b.data_pagamento_verbale_bollettario IS NOT NULL AND b.stato_bollettario != 8 AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) <=CURDATE()
                ORDER BY b.data_verbale_bollettario DESC";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, b.importo_pagamento_verbale_bollettario_pr AS importo_pagato, b.importotot_pagamento_verbale_bollettario_pr AS tot_pagamento, b.spese_notifica_verbale_bollettario_pr AS spese_notifica, b.spese_stampa_verbale_bollettario_pr AS spese_stampa, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale, DATE_FORMAT(b.data_notifica_verbale_bollettario_pr,'%d/%m/%Y') AS data_notifica, DATE_FORMAT(b.data_pagamento_verbale_bollettario_pr,'%d/%m/%Y') AS data_pagamento
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 1 AND b.data_pagamento_verbale_bollettario_pr IS NOT NULL AND b.stato_bollettario_pr != 8 AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' 
                ORDER BY b.data_verbale_bollettario_pr DESC";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, b.importo_pagamento_verbale_bollettario_pr AS importo_pagato, b.importotot_pagamento_verbale_bollettario_pr AS tot_pagamento, b.spese_notifica_verbale_bollettario_pr AS spese_notifica, b.spese_stampa_verbale_bollettario_pr AS spese_stampa, DATE_FORMAT(b.data_verbale_bollettario_pr,'%d/%m/%Y') AS data_verbale, DATE_FORMAT(b.data_notifica_verbale_bollettario_pr,'%d/%m/%Y') AS data_notifica, DATE_FORMAT(b.data_pagamento_verbale_bollettario_pr,'%d/%m/%Y') AS data_pagamento
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 1 AND b.data_pagamento_verbale_bollettario_pr IS NOT NULL AND b.stato_bollettario_pr != 8 AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE()
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