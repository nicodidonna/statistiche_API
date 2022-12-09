<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e miei_verbali.php per poterli usare
include_once '../config/db.php';
include_once '../models/miei_verbali.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}


// Creiamo un nuovo oggetto MieiVerbali e passiamoli la connessione
$miei_verbali = new MieiVerbali($db_id);

if (isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {
    //se ci sono, prendo i parametri dall'url
    $param = $_GET['data_inizio'];
    $param2 = $_GET['data_fine'];

} else {

    $stmt = $miei_verbali->read();

}

// query products
$num = $stmt->rowCount();

// se vengono trovati verbali nel database
if ($num > 0) {

    // array di verbali
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //Creazione stringa cronologico e numero verbale
        $row['cronologico'] = $row['cronologico']."/".$row['anno_verbale'];
        $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];

        //switch per assegnare l'id del tipo bollettario al suo valore
        switch ($row['tipo_bollettario']) {
            
            case '1':
                $row['tipo_bollettario'] = 'Immediato';
                break;
                
            case '2':
                $row['tipo_bollettario'] = 'Differito';
                break;
            
            default:
                # code...
                break;

        };

        //switch per assegnare l'id dello stato bollettario al suo valore
        switch ($row['stato_bollettario']) {
            
            case '0':
                $row['stato_bollettario'] = 'Non Compilato';
                break;
                
            case '1':
                $row['stato_bollettario'] = 'Scaricato';
                break;

            case '2':
                $row['stato_bollettario'] = 'Notificato';
                break;

            case '3':
                $row['stato_bollettario'] = 'Pagato';
                break;
                
            case '4':
                $row['stato_bollettario'] = 'In ricorso - Nessun Pagamento';
                break;
                
            case '5':
                $row['stato_bollettario'] = 'In ricorso - Pagamento effettuato';
                break;
                
            case '6':
                $row['stato_bollettario'] = 'Coattivo';
                break;
                
            case '7':
                $row['stato_bollettario'] = 'Pagato parzialmente';
                break;
                
            case '8':
                $row['stato_bollettario'] = 'Rateizzato';
                break;
                
            case '9':
                $row['stato_bollettario'] = 'Sospeso';
                break;  

            default:
                # code...
                break;

        };

        $table_item = array(
            "tipo_bollettario" => $row['tipo_bollettario'],
            "stato_bollettario" => $row['stato_bollettario'],
            "cronologico" => $row['cronologico'],
            "numero_verbale" => $row['numero_verbale'],
            "anno_verbale" => $row['anno_verbale'],
            "articolo" => $row['articolo'],
            "nome_docallegato" => $row['nome_docallegato'],
            "url_docallegato" => $row['url_docallegato']
        );
        array_push($verbali_arr, $table_item);

    }

    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK);  //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {
    http_response_code(404);
    echo json_encode(array("message" => "La ricerca di Verbali non ha prodotto nessun risultato."));
}


?>