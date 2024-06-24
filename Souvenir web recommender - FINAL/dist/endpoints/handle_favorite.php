<?php
session_start();
require_once '../controllers/FavoriteController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['user_id'])) {
        $productId = intval($_POST['product_id']);
        $userId = intval($_POST['user_id']);

        $favoriteController = new FavoriteController();
        $isFavorite = $favoriteController->toggleFavorite($userId, $productId);

        $response = [
            'success' => true,
            'isFavorite' => $isFavorite,
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => 'Missing required parameters.',
        ];
        echo json_encode($response);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>
