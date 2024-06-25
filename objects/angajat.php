<?php
// Clasa obiectului Angajat cu un șir de proprietăți specifice
class Angajat{

    // Conectarea la BD și denumirea tabelului
    private $conn;
    private $nume_tabel = "angajati";

    // Proprietățile obiectului
    public $id;
    public $nume;
    public $prenume;
    public $varsta;
    public $nrTel;
    public $depart;
    public $dtAng;
    public $salariu;
    public $filiala_id;
    public $filiala_denumire;
    public $created;

    // Constructor cu $db ca conexiune la BD
    public function __construct($db){
        $this->conn = $db;
    }

    // Metoda de citire a angajaților 
    function read(){

        // Interogarea pentru a obține înregistrările din BD (select all)
        $query = "SELECT
                    f.denumire as filiala_denumire, a.id, a.nume, a.prenume, a.varsta, a.nrTel, a.depart, a.dtAng, a.salariu, a.filiala_id, a.created
                FROM
                    " . $this->nume_tabel . " a
                    LEFT JOIN
                        filiale f
                            ON a.filiala_id = f.id
                ORDER BY
                    a.created DESC";

        // Pregătim instrucțiunea de interogare
        $stmt = $this->conn->prepare($query);

        // Executăm interogarea
        $stmt->execute();

        // Returnăm valorile din BD
        return $stmt;
    }

    // Metoda de creare a angajaților 
    function create(){

        // Interogarea pentru a insera înregistrarea
        $query = "INSERT INTO
                    " . $this->nume_tabel . "
                SET
                    nume=:name, prenume=:prenume, varsta=:varsta, nrTel=:nrTel, depart=:depart, dtAng=:dtAng, salariu=:salariu, filiala_id=:filiala_id, created=:created";

        // Pregătim interogarea
        $stmt = $this->conn->prepare($query);
  
        /* Sanitarizăm, adică eliminăm tag-urile HTML/PHP din string
        pentru a evita atacurile de tip cross-site scripting (XSS) */
        $this->nume=htmlspecialchars(strip_tags($this->nume));
        $this->prenume=htmlspecialchars(strip_tags($this->prenume));
        $this->varsta=htmlspecialchars(strip_tags($this->varsta));
        $this->nrTel=htmlspecialchars(strip_tags($this->nrTel));
        $this->depart=htmlspecialchars(strip_tags($this->depart));
        $this->dtAng=htmlspecialchars(strip_tags($this->dtAng));
        $this->salariu=htmlspecialchars(strip_tags($this->salariu));
        $this->filiala_id=htmlspecialchars(strip_tags($this->filiala_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
  
	// Legăm valorile
        $stmt->bindParam(":nume", $this->nume);
        $stmt->bindParam(":prenume", $this->prenume);
        $stmt->bindParam(":varsta", $this->varsta);
        $stmt->bindParam(":nrTel", $this->nrTel);
        $stmt->bindParam(":depart", $this->depart);
        $stmt->bindParam(":dtAng", $this->dtAng);
        $stmt->bindParam(":salariu", $this->salariu);
        $stmt->bindParam(":filiala_id", $this->filiala_id);
        $stmt->bindParam(":created", $this->created);
  
        // Executăm interogarea
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // Folosită la completarea formularului de actualizare a produsului
    function readOne(){

	// Interogare pentru a citi o singură înregistrare
        $query = "SELECT
                    f.denumire as filiala_denumire, a.id, a.nume, a.prenume, a.varsta, a.nrTel, a.depart, a.dtAng, a.salariu, a.filiala_id, a.created
                FROM
                    " . $this->nume_tabel . " a
                    LEFT JOIN
                        filiale f
                            ON a.filiala_id = f.id
                WHERE
                    a.id = ?
                LIMIT
                    0,1";

        // Pregătim instrucțiunea interogării
        $stmt = $this->conn->prepare($query);

	// Legăm id-ul angajatului care urmează să fie actualizat
        $stmt->bindParam(1, $this->id);

        // Executăm interogarea
        $stmt->execute();

        // Obținem rândul recuperat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Setăm valorile proprietăților obiectului
        $this->nume = $row['nume'];
        $this->prenume = $row['prenume'];
        $this->varsta = $row['varsta'];
        $this->nrTel = $row['nrTel'];
        $this->depart = $row['depart'];
        $this->dtAng = $row['dtAng'];
        $this->salariu = $row['salariu'];
        $this->filiala_id = $row['filiala_id'];
        $this->filiala_denumire = $row['filiala_denumire'];
    }

    // Metoda de editare a angajaților
    function update(){

        // Interogarea de editare
        $query = "UPDATE
                    " . $this->nume_tabel . "
                SET
                    nume = :nume,
                    prenume = :prenume,
                    varsta = :varsta,
                    nrTel = :nrTel,
                    depart = :depart,
                    dtAng = :dtAng,
                    salariu = :salariu,
                    filiala_id = :filiala_id
                WHERE
                    id = :id";

        // Pregătim instrucțiunea interogării
        $stmt = $this->conn->prepare($query);

        /* Sanitarizăm, adică eliminăm tag-urile HTML/PHP din string
        pentru a evita atacurile de tip cross-site scripting (XSS) */
        $this->nume=htmlspecialchars(strip_tags($this->nume));
        $this->prenume=htmlspecialchars(strip_tags($this->prenume));
        $this->varsta=htmlspecialchars(strip_tags($this->varsta));
        $this->nrTel=htmlspecialchars(strip_tags($this->nrTel));
        $this->depart=htmlspecialchars(strip_tags($this->depart));
        $this->dtAng=htmlspecialchars(strip_tags($this->dtAng));
        $this->salariu=htmlspecialchars(strip_tags($this->salariu));
        $this->filiala_id=htmlspecialchars(strip_tags($this->filiala_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Legăm noile valori
        $stmt->bindParam(":nume", $this->nume);
        $stmt->bindParam(":prenume", $this->prenume);
        $stmt->bindParam(":varsta", $this->varsta);
        $stmt->bindParam(":nrTel", $this->nrTel);
        $stmt->bindParam(":depart", $this->depart);
        $stmt->bindParam(":dtAng", $this->dtAng);
        $stmt->bindParam(":salariu", $this->salariu);
        $stmt->bindParam(":filiala_id", $this->filiala_id);
        $stmt->bindParam(':id', $this->id);

        // Executăm interogarea
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // Metoda de ștergere a angajaților 
    function delete(){
  
        // Interogarea de ștergere
        $query = "DELETE FROM " . $this->nume_tabel . " WHERE id = ?";
  
        // Pregătim interogarea
        $stmt = $this->conn->prepare($query);
  
        /* Sanitarizăm, adică eliminăm tag-urile HTML/PHP din string
        pentru a evita atacurile de tip cross-site scripting (XSS) */
        $this->id=htmlspecialchars(strip_tags($this->id));
  
        // Legăm id-ul înregistrării de șters
        $stmt->bindParam(1, $this->id);
  
        // Executăm interogarea
        if($stmt->execute()){
            return true;
        }
  
        return false;
    }

    // Metoda de căutare a angajaților 
    function search($keywords){
  
        // Interogare select all
        $query = "SELECT
                    f.denumire as filiala_denumire, a.id, a.nume, a.prenume, a.varsta, a.nrTel, a.depart, a.dtAng, a.salariu, a.filiala_id, a.created
                FROM
                    " . $this->nume_tabel . " a
                    LEFT JOIN
                        filiale f
                            ON a.filiala_id = f.id
                WHERE
                    a.nume LIKE ? OR a.prenume LIKE ? OR a.nrTel LIKE ?
                ORDER BY
                    a.created DESC";
  
        // Pregătim instrucțiunea interogării
        $stmt = $this->conn->prepare($query);
  
        /* Sanitarizăm, adică eliminăm tag-urile HTML/PHP din string
        pentru a evita atacurile de tip cross-site scripting (XSS) */
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
  
        // Legarea parametrilor
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
  
        // Executăm interogarea
        $stmt->execute();

        // Returnăm valorile din BD
        return $stmt;
    }

    // Citirea angajaților cu paginare
    public function readPaging($from_record_num, $records_per_page){
  
        // Interogarea de selectare
        $query = "SELECT
                    f.denumire as filiala_denumire, a.id, a.nume, a.prenume, a.varsta, a.nrTel, a.depart, a.dtAng, a.salariu, a.filiala_id, a.created
                FROM
                    " . $this->nume_tabel . " a
                    LEFT JOIN
                        filiale f
                            ON a.filiala_id = f.id
                ORDER BY a.created DESC
                LIMIT ?, ?";

        // Pregătim instrucțiunea interogării
        $stmt = $this->conn->prepare($query);
  
        // Legarea valorile variabilelor
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  
        // Executăm interogarea
        $stmt->execute();
  
        // Returnăm valorile din BD
        return $stmt;
    }

    // Utilizată pentru paginarea angajaților
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->nume_tabel . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
}
?>