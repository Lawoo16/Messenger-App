<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
    $message = $data['message'];

    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo json_encode(['success' => true]);
} else {
    $stmt = $conn->prepare("SELECT * FROM messages ORDER BY id DESC");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
}
