<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_sanzioneacc.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_sanzioneacc.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto VerbaliSanzioneAcc e passiamoli la connessione
$verbali_sanzioneacc = new VerbaliSanzioneAcc($db_id);

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if( isset($_GET['tipoRead']) ){
    
    $GLOBALS['tipoRead'] = $_GET['tipoRead'];
    
    if ( isset($_GET['data_verbale_inizio']) and isset($_GET['data_verbale_fine']) ) {

        //prendo i parametri dall'url
        $data_verbale_inizio = $_GET['data_verbale_inizio'];
        $data_verbale_fine = $_GET['data_verbale_fine'];
        
        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead'], $data_verbale_inizio, $data_verbale_fine);
    
    } else if (isset($_GET['data_creazione_inizio']) and isset($_GET['data_creazione_fine'])){
        
        $data_creazione_inizio = $_GET['data_creazione_inizio'];
        $data_creazione_fine = $_GET['data_creazione_fine'];

        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead'], null, null, $data_creazione_inizio, $data_creazione_fine);

    } else {
        
        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead']);
    
    }

}


// query products
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if($num>0){
    
    // array di risultati
    $verbali_arr = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali'){

            switch ($row['tipo_sanzione_accessoria']) {

                case '100':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione con il ritiro del documento";
                    break;

                case '101':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della licenza";
                    break;
                    
                case '102':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida senza il ritiro del documento";
                    break;
                    
                case '103':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa del veicolo";
                    break;
                    
                case '104':
                    $row['tipo_sanzione_accessoria'] = "Obbligo delle rimozioni delle opere abusive";
                    break;
                    
                case '105':
                    $row['tipo_sanzione_accessoria'] = "Sospensione dell'autorizzazione";
                    break;
                    
                case '106':
                    $row['tipo_sanzione_accessoria'] = "Revoca della patente di guida";
                    break;
                    
                case '107':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della patente di guida";
                    break;
                    
                case '110':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida con ritiro del documento";
                    break;
                    
                case '111':
                    $row['tipo_sanzione_accessoria'] = "Obbligo di ripristino dei luoghi";
                    break;
                    
                case '112':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa di oggetti effetto della violazione";
                    break;
                    
                case '113':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della targa";
                    break;
                    
                case '114':
                    $row['tipo_sanzione_accessoria'] = "Sequestro amministrativo del veicolo";
                    break;
                    
                case '116':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione senza il ritiro del documento";
                    break;
                    
                case '117':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della carta di circolazione";
                    break;
                    
                case '118':
                    $row['tipo_sanzione_accessoria'] = "Segnalazione patente";
                    break;
                    
                case '119':
                    $row['tipo_sanzione_accessoria'] = "Fermo amministrativo";
                    break;
                    
                case '120':
                    $row['tipo_sanzione_accessoria'] = "Alienazione veicolo";
                    break;
                    
                case '121':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per rottamazione";
                    break;
                    
                case '122':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per riattivazione assicurazione entro 30 giorni";
                    break;
                    
                case '123':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per pagamento assicurazione";
                    break;
                    
                case '124':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro con targa prova";
                    break;    
                
                default:
                    $row['tipo_sanzione_accessoria'] = "Tipo di sanzione accessoria non riconosciuto";
                    break;
            }
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }
        
        //se chiedo preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'preavvisi'){

            switch ($row['tipo_sanzione_accessoria']) {

                case '100':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione con il ritiro del documento";
                    break;

                case '101':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della licenza";
                    break;
                    
                case '102':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida senza il ritiro del documento";
                    break;
                    
                case '103':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa del veicolo";
                    break;
                    
                case '104':
                    $row['tipo_sanzione_accessoria'] = "Obbligo delle rimozioni delle opere abusive";
                    break;
                    
                case '105':
                    $row['tipo_sanzione_accessoria'] = "Sospensione dell'autorizzazione";
                    break;
                    
                case '106':
                    $row['tipo_sanzione_accessoria'] = "Revoca della patente di guida";
                    break;
                    
                case '107':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della patente di guida";
                    break;
                    
                case '110':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida con ritiro del documento";
                    break;
                    
                case '111':
                    $row['tipo_sanzione_accessoria'] = "Obbligo di ripristino dei luoghi";
                    break;
                    
                case '112':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa di oggetti effetto della violazione";
                    break;
                    
                case '113':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della targa";
                    break;
                    
                case '114':
                    $row['tipo_sanzione_accessoria'] = "Sequestro amministrativo del veicolo";
                    break;
                    
                case '116':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione senza il ritiro del documento";
                    break;
                    
                case '117':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della carta di circolazione";
                    break;
                    
                case '118':
                    $row['tipo_sanzione_accessoria'] = "Segnalazione patente";
                    break;
                    
                case '119':
                    $row['tipo_sanzione_accessoria'] = "Fermo amministrativo";
                    break;
                    
                case '120':
                    $row['tipo_sanzione_accessoria'] = "Alienazione veicolo";
                    break;
                    
                case '121':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per rottamazione";
                    break;
                    
                case '122':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per riattivazione assicurazione entro 30 giorni";
                    break;
                    
                case '123':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per pagamento assicurazione";
                    break;
                    
                case '124':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro con targa prova";
                    break;    
                
                default:
                    $row['tipo_sanzione_accessoria'] = "Tipo di sanzione accessoria non riconosciuto";
                    break;
            }
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }

        //se chiedo verbali e preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali_preavvisi'){

            switch ($row['tipo_sanzione_accessoria']) {

                case '100':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione con il ritiro del documento";
                    break;

                case '101':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della licenza";
                    break;
                    
                case '102':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida senza il ritiro del documento";
                    break;
                    
                case '103':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa del veicolo";
                    break;
                    
                case '104':
                    $row['tipo_sanzione_accessoria'] = "Obbligo delle rimozioni delle opere abusive";
                    break;
                    
                case '105':
                    $row['tipo_sanzione_accessoria'] = "Sospensione dell'autorizzazione";
                    break;
                    
                case '106':
                    $row['tipo_sanzione_accessoria'] = "Revoca della patente di guida";
                    break;
                    
                case '107':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della patente di guida";
                    break;
                    
                case '110':
                    $row['tipo_sanzione_accessoria'] = "Sospensione della patente di guida con ritiro del documento";
                    break;
                    
                case '111':
                    $row['tipo_sanzione_accessoria'] = "Obbligo di ripristino dei luoghi";
                    break;
                    
                case '112':
                    $row['tipo_sanzione_accessoria'] = "Confisca amministrativa di oggetti effetto della violazione";
                    break;
                    
                case '113':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della targa";
                    break;
                    
                case '114':
                    $row['tipo_sanzione_accessoria'] = "Sequestro amministrativo del veicolo";
                    break;
                    
                case '116':
                    $row['tipo_sanzione_accessoria'] = "Sospensione carta di circolazione senza il ritiro del documento";
                    break;
                    
                case '117':
                    $row['tipo_sanzione_accessoria'] = "Ritiro della carta di circolazione";
                    break;
                    
                case '118':
                    $row['tipo_sanzione_accessoria'] = "Segnalazione patente";
                    break;
                    
                case '119':
                    $row['tipo_sanzione_accessoria'] = "Fermo amministrativo";
                    break;
                    
                case '120':
                    $row['tipo_sanzione_accessoria'] = "Alienazione veicolo";
                    break;
                    
                case '121':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per rottamazione";
                    break;
                    
                case '122':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per riattivazione assicurazione entro 30 giorni";
                    break;
                    
                case '123':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro per pagamento assicurazione";
                    break;
                    
                case '124':
                    $row['tipo_sanzione_accessoria'] = "Dissequestro con targa prova";
                    break;    
                
                default:
                    $row['tipo_sanzione_accessoria'] = "Tipo di sanzione accessoria non riconosciuto";
                    break;
            }
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }
        
        array_push($verbali_arr, $table_item);
        
    }
    
    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {
    
    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali per Sanzione Accessoria non ha prodotto nessun risultato.") ); 

}

?>