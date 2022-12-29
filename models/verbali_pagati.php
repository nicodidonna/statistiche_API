<?php


class VerbaliPagati
{

    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }

    // READ verbali_pagati
    function read($tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, b.importo_pagamento_verbale_bollettario AS importo_pagato, b.importotot_pagamento_verbale_bollettario AS tot_pagamento, b.spese_notifica_verbale_bollettario AS spese_notifica, b.spese_stampa_verbale_bollettario AS spese_stampa, b.data_verbale_bollettario AS data_verbale, b.data_notifica_verbale_bollettario AS data_notifica, b.data_pagamento_verbale_bollettario AS data_pagamento
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 0 AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine' ";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario AS cronologico, b.numero_bollettario AS numero_verbale, b.anno_bollettario AS anno_verbale, b.stato_bollettario AS stato_verbale, b.importo_pagamento_verbale_bollettario AS importo_pagato, b.importotot_pagamento_verbale_bollettario AS tot_pagamento, b.spese_notifica_verbale_bollettario AS spese_notifica, b.spese_stampa_verbale_bollettario AS spese_stampa, b.data_verbale_bollettario AS data_verbale, b.data_notifica_verbale_bollettario AS data_notifica, b.data_pagamento_verbale_bollettario AS data_pagamento
                FROM db2_bollettario AS b
                WHERE b.stato_pagamento_verbale_bollettario = 0 AND b.stato_archivio_verbale_bollettario = 0 AND CAST(b.data_verbale_bollettario AS DATE) <=CURDATE()";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, b.importo_pagamento_verbale_bollettario_pr AS importo_pagato, b.importotot_pagamento_verbale_bollettario_pr AS tot_pagamento, b.spese_notifica_verbale_bollettario_pr AS spese_notifica, b.spese_stampa_verbale_bollettario_pr AS spese_stampa, b.data_verbale_bollettario_pr AS data_verbale, b.data_notifica_verbale_bollettario_pr AS data_notifica, b.data_pagamento_verbale_bollettario_pr AS data_pagamento
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 0 AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' ";
                
            } else {
                
                $query = "SELECT b.num_ordine_bollettario_pr AS cronologico, b.numero_bollettario_pr AS numero_verbale, b.anno_bollettario_pr AS anno_verbale, b.stato_bollettario_pr AS stato_verbale, b.importo_pagamento_verbale_bollettario_pr AS importo_pagato, b.importotot_pagamento_verbale_bollettario_pr AS tot_pagamento, b.spese_notifica_verbale_bollettario_pr AS spese_notifica, b.spese_stampa_verbale_bollettario_pr AS spese_stampa, b.data_verbale_bollettario_pr AS data_verbale, b.data_notifica_verbale_bollettario_pr AS data_notifica, b.data_pagamento_verbale_bollettario_pr AS data_pagamento
                FROM db6_bollettario_pr AS b
                WHERE b.stato_pagamento_verbale_bollettario_pr = 0 AND b.stato_archivio_verbale_bollettario_pr = 0 AND CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE()";
                
            }

        }
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    
    }

}


?>