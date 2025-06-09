<?php
include 'components/connect.php';

$motherboard_id = $_GET['motherboard_id'] ?? '';

if ($motherboard_id) {
    $result = [];

    // Fetch compatible components for specific categories
    $compatible_categories = ['cpu', 'gpu', 'ram', 'power supply', 'cooler', 'case'];
    foreach ($compatible_categories as $category) {
        $stmt = $conn->prepare("SELECT bc.* FROM `build_components` bc
                                JOIN `compatible` c ON bc.id = c.component_id
                                WHERE c.motherboard_id = ? AND c.category = ?");
        $stmt->execute([$motherboard_id, $category]);
        $result[$category] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all storage components (not filtered by compatibility)
    $stmt = $conn->prepare("SELECT * FROM `build_components` WHERE category = 'storage'");
    $stmt->execute();
    $result['storage'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
?>
