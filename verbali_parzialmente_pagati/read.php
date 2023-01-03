<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_parzialmente_pagati.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_parzialmente_pagati.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto VerbaliParzialmentePagati e passiamoli la connessione
$verbali_parzialmente_pagati = new VerbaliParzialmentePagati($db_id);

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if( isset($_GET['tipoRead']) ){
    
    $GLOBALS['tipoRead'] = $_GET['tipoRead'];
    
    if ( isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {
        
        //prendo i parametri dall'url
        $param = $_GET['data_inizio'];
        $param2 = $_GET['data_fine'];
        
        $stmt = $verbali_parzialmente_pagati->read($GLOBALS['tipoRead'],$param,$param2);
    
    } else {
        
        $stmt = $verbali_parzialmente_pagati->read($GLOBALS['tipoRead']);
    
    }

}

// query products
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if ($num > 0) {

    // array di risultati
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali'){

            $row['cronologico'] = $row['cronologico']."/".$row['anno_verbale'];
            $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];

            switch ($row['stato_verbale']) {

                case '0':
                    $row['stato_verbale'] = 'Non compilato';
                    break;
                
                case '1':
                    $row['stato_verbale'] = 'Scaricato';
                    break;
                    
                case '2':
                    $row['stato_verbale'] = 'Notificato';
                    break;
                    
                case '3':
                    $row['stato_verbale'] = 'Pagato';
                    break;
                    
                case '4':
                    $row['stato_verbale'] = 'In ricorso - Nessun pagamento';
                    break;
                    
                case '5':
                    $row['stato_verbale'] = 'In ricorso - Pagamento effettuato';
                    break;
                    
                case '6':
                    $row['stato_verbale'] = 'Coattivo';
                    break;
                    
                case '7':
                    $row['stato_verbale'] = 'Pagato parzialmente';
                    break;
                    
                case '8':
                    $row['stato_verbale'] = 'Rateizzato';
                    break;
                    
                case '9':
                    $row['stato_verbale'] = 'Sospeso';
                    break;    
                
                default:
                    $row['stato_verbale'] = 'Stato verbale non riconosciuto';
                    break;
            }
            
            $table_item = array(
                "cronologico" => $row['cronologico'],
                "numero_verbale" => $row['numero_verbale'],
                "stato_verbale" => $row['stato_verbale'],
                "importo_pagato" => $row['importo_pagato'],
                "tot_pagamento" => $row['tot_pagamento'],
                "spese_notifica" => $row['spese_notifica'],
                "spese_stampa" => $row['spese_stampa'],
                "data_verbale" => $row['data_verbale'],
                "data_notifica" => $row['data_notifica'],
                "data_pagamento" => $row['data_pagamento']
            );

        }


        //se chiedo preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'preavvisi'){

            $row['cronologico'] = $row['numero_verbale']."/PR";
            $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];

            switch ($row['stato_verbale']) {

                case '0':
                    $row['stato_verbale'] = 'Non compilato';
                    break;
                
                case '1':
                    $row['stato_verbale'] = 'Scaricato';
                    break;
                    
                case '2':
                    $row['stato_verbale'] = 'Notificato';
                    break;
                    
                case '3':
                    $row['stato_verbale'] = 'Pagato';
                    break;
                    
                case '4':
                    $row['stato_verbale'] = 'In ricorso - Nessun pagamento';
                    break;
                    
                case '5':
                    $row['stato_verbale'] = 'In ricorso - Pagamento effettuato';
                    break;
                    
                case '6':
                    $row['stato_verbale'] = 'Coattivo';
                    break;
                    
                case '7':
                    $row['stato_verbale'] = 'Pagato parzialmente';
                    break;
                    
                case '8':
                    $row['stato_verbale'] = 'Rateizzato';
                    break;
                    
                case '9':
                    $row['stato_verbale'] = 'Sospeso';
                    break;    
                
                default:
                    $row['stato_verbale'] = 'Stato verbale non riconosciuto';
                    break;
            }
            
            $table_item = array(
                "cronologico" => $row['cronologico'],
                "numero_verbale" => $row['numero_verbale'],
                "stato_verbale" => $row['stato_verbale'],
                "importo_pagato" => $row['importo_pagato'],
                "tot_pagamento" => $row['tot_pagamento'],
                "spese_notifica" => $row['spese_notifica'],
                "spese_stampa" => $row['spese_stampa'],
                "data_verbale" => $row['data_verbale'],
                "data_notifica" => $row['data_notifica'],
                "data_pagamento" => $row['data_pagamento']
            );

        }
        
        array_push($verbali_arr, $table_item);

    }

    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK);  //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {
    http_response_code(404);
    echo json_encode(array("message" => "La ricerca di Verbali o Preavvisi parzialmente pagati non ha prodotto nessun risultato."));
}


?>