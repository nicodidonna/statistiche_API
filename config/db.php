<?php

class Database
{
    // credenziali
    private $host = "localhost";
    private $db_name = "";
    private $username = "root";
    private $password = "";


    /* Istanza unica del singleton* @var object */
    private static $instance;

    /* Costruttore privato per prevenire che venga istanziato da codice esterno. */
    private function __construct($id)
    {
        switch ($id) {
            case 1:
                $this->db_name = 'sanzioni_rutigliano';
                break;
            case 2:
                $this->db_name = 'sanzioni_noicattaro';
                break;
            case 3:
                $this->db_name = 'sanzioni1.0';
                break;
        }
        $this->getConnection();
    }

    /** Metodo pubblico per l'accesso all'istanza unica di classe.
     * @return object|Database
     */
    public static function getInstance($id)
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database($id);
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