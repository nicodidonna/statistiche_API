<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e libro.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_by_preavviso.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto VerbaliPreavviso e passiamoli la connessione
$verbali_preavviso = new VerbaliPreavviso($db);

//prendo i parametri dall'url
$param = $_GET['data_inizio'];
$param2 = $_GET['data_fine'];

// query products
$stmt = $verbali_preavviso->read($param, $param2);
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
    echo json_encode($verbali_arr);

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali provenienti da Preavviso non ha prodotto nessun risultato.") ); 

}


?>