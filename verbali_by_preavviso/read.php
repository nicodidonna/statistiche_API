<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_by_preavviso.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_by_preavviso.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto VerbaliPreavviso e passiamoli la connessione
$verbali_preavviso = new VerbaliPreavviso($db_id);

if (isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {

    //prendo i parametri dall'url
    $param = $_GET['data_inizio'];
    $param2 = $_GET['data_fine'];
    $stmt = $verbali_preavviso->read($param, $param2);

} else {

    $stmt = $verbali_preavviso->read();

}

// query products
$num = $stmt->rowCount();

// se vengono trovati libri nel database
if($num>0){

    // array di libri
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $row['cronologico'] = $row['cronologico']."/".$row['anno_verbale'];
        $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];

        $table_item = array(
            "cronologico" => $row['cronologico'],
            "numero_verbale" => $row['numero_verbale'],
            "data_verbale" => $row['data_verbale'],
            "articolo" => $row['articolo']
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali provenienti da Preavviso non ha prodotto nessun risultato.") ); 

}


?>