<?php

class Database
{
    // credenziali
    private $host = "localhost";
    private $db_name = "sanzioni_rutigliano";
    private $username = "root";
    private $password = "";


    /* Istanza unica del singleton* @var object */
    private static $instance;

    /* Costruttore privato per prevenire che venga istanziato da codice esterno. */
    private function __construct()
    {
        $this->getConnection();
    }

    /** Metodo pubblico per l'accesso all'istanza unica di classe.
     * @return object|Database
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance->getConnection();
    }

    // connessione al database
    private function getConnection()
    {
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn->exec("set names utf8");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $exception) {
            echo "Errore di connessione: " . $exception->getMessage();
        }

    }

}


?>