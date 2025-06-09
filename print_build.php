<?php
// print_build.php

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include 'components/connect.php'; // Include database connection

// Retrieve selected components from query parameters
$selectedComponents = [
    'motherboard' => $_GET['motherboard'] ?? null,
    'cpu' => $_GET['cpu'] ?? null,
    'gpu' => $_GET['gpu'] ?? null,
    'ram' => $_GET['ram'] ?? null,
    'storage' => $_GET['storage'] ?? null,
    'power_supply' => $_GET['power_supply'] ?? null,
    'cooler' => $_GET['cooler'] ?? null,
    'case' => $_GET['case'] ?? null,
];

// Fetch component details from the database based on selected IDs
$componentsDetails = [];
foreach ($selectedComponents as $key => $id) {
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM build_components WHERE id = ?");
        $stmt->execute([$id]);
        $componentsDetails[$key] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Build Summary</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .summary-container { 
            max-width: 1200px; 
            margin: auto; 
            font-size: 1.6rem; 
        }
        h1 { 
            text-align: center; 
            margin-bottom: 2rem;
            font-size: 3.5rem; 
        }
        h2 {
            font-size: 2.8rem; 
        }
        .selected-components { 
            margin-top: 30px; 
            padding: 40px; 
            background: #f5f5f5; 
            border-radius: 10px; 
        }
        .selected-components li {
            margin: 20px 0; 
            font-size: 1.8rem; 
        }
        .print-button {
            text-align: center;
            margin: 30px 0;
        }
        .print-button button {
            font-size: 1.6rem;
            padding: 15px 30px;
            cursor: pointer;
        }
        @media print { .no-print { display: none; } .summary-container { padding: 20px; } }
    </style>
</head>
<body>

<div class="summary-container">
    <h1>
        <img src="images/pcbuilderhub.png" alt="Logo" style="max-width: 100%; height: auto;"></h1>
    
    <div class="selected-components">
        <h2>Selected Components:</h2>
        <ul>
            <?php foreach ($componentsDetails as $component): ?>
                <?php if ($component): ?>
                    <li>
                        <strong><?= htmlspecialchars($component['name']) ?></strong> - RM <?= htmlspecialchars($component['price']) ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="print-button no-print">
        <button onclick="window.print()">Print Build</button>
    </div>
</div>

</body>
</html>
