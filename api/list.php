<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database
include_once 'config/database.php';

// database connectie
$database = new Database();
$db = $database->getConnection();

// query bezienswaardigheden
$query = "SELECT 
            id,
            name,
            comment,
            created_at
          FROM comments
          ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {

    $comments_arr = array();
    $comments_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "id" => $id,
            "name" => $name,
            "comment" => html_entity_decode($comment),
            "created_at" => $created_at
        );

        array_push($comments_arr["records"], $item);
    }

    http_response_code(200);

    echo json_encode($comments_arr);

} else {

    http_response_code(404);

    echo json_encode(
        array("message" => "Geen comments gevonden.")
    );
}
?>