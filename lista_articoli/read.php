<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e lista_articoli.php per poterli usare
include_once '../config/db.php';
include_once '../models/lista_articoli.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto ListaArticoli e passiamoli la connessione
$lista_articoli = new ListaArticoli($db);

// query products
$stmt = $lista_articoli->read();
$num = $stmt->rowCount();

// se vengono trovati libri nel database
if($num>0){

    // array di libri
    $articoli_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $table_item = array(
            "articolo" => $row['articolo'],
        );
        array_push($articoli_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($articoli_arr, JSON_NUMERIC_CHECK); //ENCODIAMO articoli_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Articoli non ha prodotto nessun risultato.") ); 

}


?>