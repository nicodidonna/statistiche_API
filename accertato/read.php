<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e incassato.php per poterli usare
include_once '../config/db.php';
include_once '../models/accertato.php';

// Creiamo un nuovo oggetto Incassato e passiamoli la connessione
$accertato = new Accertato();

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if( isset($_GET['tipoRead']) ){

    $GLOBALS['tipoRead'] = $_GET['tipoRead'];

    if ( isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {

        //prendo i parametri dall'url
        $param = $_GET['data_inizio'];
        $param2 = $_GET['data_fine'];
        

        $stmt = $accertato->read($GLOBALS['tipoRead'],$param,$param2);

    } else {
        
        $stmt = $accertato->read($GLOBALS['tipoRead']);

    }

}

// query products
$num = $stmt->rowCount();

// se vengono trovati verbali/preavvisi nel database
if ($num > 0) {

    // array vuoto di verbali/preavvisi
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali'){

            //verifico il tipo bollettario ed assegno immediato se il tipo è 1
            if( $row['tipo_bollettario'] == 1 ){
                $row['tipo_bollettario'] = 'Immediato';
            };

            //verifico il tipo bollettario ed assegno immediato se il tipo è 2
            if( $row['tipo_bollettario'] == 2 ){
                $row['tipo_bollettario'] = 'Differito';
            };

        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
            $table_item = array(
                "importo_ridotto_60gg" => $row['Imp_Ridotto_60gg_euro'],
                "spese_notifica" => $row['spese_notifica_verbale_bollettario'],
                "spese_stampa" => $row['spese_stampa_verbale_bollettario'],
                "tipo_bollettario" => $row['tipo_bollettario']
            );

        }

        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'preavvisi'){

             //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
             $table_item = array(
                "importo_ridotto_60gg" => $row['Imp_Ridotto_60gg_euro']
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