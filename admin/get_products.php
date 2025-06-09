<?php
include '../components/connect.php';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    
    $stmt = $conn->prepare("SELECT name, price FROM `build_components` WHERE category = ?");
    $stmt->execute([$category]);
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($products)) {
        echo json_encode(['error' => 'No products found for this category.']);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($products);
} 