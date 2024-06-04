<?php
require_once 'config.php';

session_start();

header('Content-Type: application/json');

$sender_id = $_SESSION['id']; 
$receiver_id = $_POST['user_id'];
$message = $_POST['message'];

$response = ['success' => false];

if (isset($message, $receiver_id)) {
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = "Failed to execute statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['error'] = "Failed to prepare statement: " . $link->error;
    }
} else {
    $response['error'] = "Required data missing";
}

echo json_encode($response);
?>