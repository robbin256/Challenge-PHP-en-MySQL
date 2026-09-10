<?php

header('Content-Type: application/json');

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Ongeldige aanvraag."
    ]);
    exit;
}

$email = $_POST['email'] ?? '';
$name = $_POST['name'] ?? '';
$comment = $_POST['comment'] ?? '';

if (empty($email) || empty($name) || empty($comment)) {
    echo json_encode([
        "success" => false,
        "message" => "Vul alle velden in."
    ]);
    exit;
}

try {

    $query = "
        INSERT INTO comments 
        (email, name, comment)
        VALUES
        (:email, :name, :comment)
    ";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":comment", $comment);

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Comment toegevoegd.",
            "id" => $db->lastInsertId()
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Toevoegen mislukt."
        ]);

    }

} catch(PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}

?>