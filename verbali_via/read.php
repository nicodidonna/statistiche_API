<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_via.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_via.php';

// Creiamo un nuovo oggetto VerbaliVia e passiamoli la connessione
$verbali_via = new VerbaliVia();

if (isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {

    //prendo i parametri dall'url
    $param = $_GET['data_inizio'];
    $param2 = $_GET['data_fine'];
    $stmt = $verbali_via->read($param, $param2);

} else {

    $stmt = $verbali_via->read();

}

// query products
$num = $stmt->rowCount();

// se vengono trovati libri nel database
if($num>0){

    // array di libri
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table_item = array(
            "tipo_strada" => $row['tipo_strada'],
            "nome_strada" => $row['nome_strada'],
            "num_verbali" => $row['num_verbali'],
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali per Via non ha prodotto nessun risultato.") ); 

}


?>