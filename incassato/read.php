<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e incassato.php per poterli usare
include_once '../config/db.php';
include_once '../models/incassato.php';

// Creiamo un nuovo oggetto Incassato e passiamoli la connessione
$incassato = new Incassato();

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if( isset($_GET['tipoRead']) ){

    $GLOBALS['tipoRead'] = $_GET['tipoRead'];

    $stmt = $incassato->read($GLOBALS['tipoRead']);

}

// if ( isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {
//     //prendo i parametri dall'url
//     $param = $_GET['data_inizio'];
//     $param2 = $_GET['data_fine'];
//     $stmt = $verbali_agente->read($param, $param2);

// } else {

//     $stmt = $verbali_agente->read();

// }

// query products
$num = $stmt->rowCount();

// se vengono trovati verbali/preavvisi nel database
if ($num > 0) {

    // array vuoto di verbali/preavvisi
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali'){

            $table_item = array(
                "importo_pagamento_verbale" => $row['importo_pagamento_verbale_bollettario'],
                "spese_notifica_verbale" => $row['spese_notifica_verbale_bollettario'],
                "spese_stampa_verbale" => $row['spese_stampa_verbale_bollettario']
            );

        }

        //se chiedo preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'preavvisi'){

            $table_item = array(
                "importo_pagamento_preavviso" => $row['importo_pagamento_verbale_bollettario_pr'],
                "spese_notifica_preavviso" => $row['spese_notifica_verbale_bollettario_pr'],
                "spese_stampa_preavviso" => $row['spese_stampa_verbale_bollettario_pr']
            );

        }
        
        //pusho l'array $table_item in $verbali_arr
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK);  //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {
    http_response_code(404);
    echo json_encode(array("message" => "La ricerca di Verblali/Preavvisi non ha prodotto nessun risultato."));
}


?>