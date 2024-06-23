<?php
require_once '../models/Comment.php';

class CommentController {
    private $comment;

    public function __construct() {
        $this->comment = new Comment();
    }

    public function getComments($productId) {
        return $this->comment->getCommentsByProductId($productId);
    }

    public function addComment($productId, $userId, $comment) {
        $success = $this->comment->addComment($productId, $userId, $comment);
        if ($success) {
            $username = $this->comment->getUsernameById($userId);
            $timestamp = date('Y-m-d H:i:s'); // Obții data și ora curentă
            return json_encode(['success' => true, 'username' => $username, 'timestamp' => $timestamp, 'comment_id' => $this->comment->getLastInsertId()]);
        } else {
            return json_encode(['success' => false]);
        }
    }

    public function deleteComment($commentId, $userId) {
        $success = $this->comment->deleteComment($commentId, $userId);
        return json_encode(['success' => $success]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $action = $_POST['action'];
    $commentController = new CommentController();

    if ($action === 'addComment') {
        $productId = intval($_POST['product_id']);
        $userId = intval($_POST['user_id']);
        $comment = $_POST['comment'];
        echo $commentController->addComment($productId, $userId, $comment);
    } elseif ($action === 'deleteComment') {
        $commentId = intval($_POST['comment_id']);
        $userId = $_SESSION['user_id'];
        echo $commentController->deleteComment($commentId, $userId);
    }
}
?>
