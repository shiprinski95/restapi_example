<?php
class Filiala{
  
    // Conectarea la BD și denumirea tabelului
    private $conn;
    private $nume_tabel = "filiale";
  
    // Proprietățile obiectului
    public $id;
    public $denumire;
    public $adresa;
    public $created;

    // Constructor cu $db ca conexiune la BD
    public function __construct($db){
        $this->conn = $db;
    }

    // Folosită de lista derulantă de selectare
    public function readAll(){
        // Selectăm toate datele
        $query = "SELECT
                    id, denumire, adresa
                FROM
                    " . $this->nume_tabel . "
                ORDER BY
                    denumire";
  
        // Pregătim instrucțiunea de interogare
        $stmt = $this->conn->prepare($query);

        // Executăm interogarea
        $stmt->execute();

        // Returnăm valorile din BD
        return $stmt;
    }


    // Folosită de lista derulantă de selectare
    public function read(){
        // Selectăm toate datele
        $query = "SELECT
                    id, denumire, adresa
                FROM
                    " . $this->nume_tabel . "
                ORDER BY
                    denumire";
  
        // Pregătim instrucțiunea de interogare
        $stmt = $this->conn->prepare($query);

        // Executăm interogarea
        $stmt->execute();

        // Returnăm valorile din BD
        return $stmt;
    }
}
?>