<?php
// Header necesar ce indică că fișierul poate fi citit de oricine (asterisk *)
header("Access-Control-Allow-Origin: *");
// Header necesar ce indică ce tip de conținut va fi returnat (date în format JSON)
header("Content-Type: application/json; charset=UTF-8");
// Observăm că am setat charset-ul Unicode pentru diacritice

// Includem script-urile PHP necesare create anterior
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/angajat.php';

// Utilitățile
$utilities = new Utilities();
  
// Instanțiăm obiectele bazei de date și angajatului. 
$database = new Database();
$db = $database->getConnection();
  
// Inițializăm obiectul
$angajat = new Angajat($db);
  
// Interogăm angajații
$stmt = $angajat->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// Dacă a fost găsită măcar o înregistrare
if($num>0){
  
    // Declarăm array-ul pentru stocarea angajaților
    $angajati_arr=array();
    $angajati_arr["records"]=array();
    $angajati_arr["paging"]=array();
  
    /* Parcurgem tabelul folosind ciclul while în vederea obținerii conținutului
    tabelului. fetch() este mai rapid decât fetchAll() în cadrul unui ciclu */
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	// Extragem rândul, acest lucru va face $row['nume'] pur și simplu în $nume
        extract($row);

	// Adăugăm fiecare înregistrare în array-ul $angajati_arr
        $angajat_item=array(
            "id" => $id,
            "nume" => $nume,
	    "prenume" => $prenume,
            "varsta" => $varsta,
            "nrTel" => $nrTel,
            "depart" => $depart,
            "varsta" => $varsta,
            "dtAng" => $dtAng,
            "salariu" => $salariu,
            "filiala_id" => $filiala_id,
            "filiala_denumire" => $filiala_denumire
        );
  
        array_push($angajati_arr["records"], $angajat_item);
    }
  
  
    // Includem paginarea
    $total_rows=$angajat->count();
    $page_url="{$home_url}angajat/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $angajati_arr["paging"]=$paging;
  
    // Setăm codul de răspuns - 200 OK
    http_response_code(200);

    // Afișăm utilizatorului datele angajaților în format JSON
    echo json_encode($angajati_arr);
}

/* Dacă variabila $num are valoarea zero sau negativă
înseamnă că nu sunt înregistrări returnate din BD */
else{

    // Setăm codul de răspuns - 404 Not Found
    http_response_code(404);

    // Afișăm mesajul corespunzător pentru utilizator
    echo json_encode(
        array("message" => "Nu s-au găsit angajați.")
    );
}
?>