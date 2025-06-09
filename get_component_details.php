<?php
include 'components/connect.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM build_components WHERE id = ?");
        $stmt->execute([$id]);
        $component = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($component) {
            header('Content-Type: application/json');
            echo json_encode($component);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Component not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No ID provided']);
} 