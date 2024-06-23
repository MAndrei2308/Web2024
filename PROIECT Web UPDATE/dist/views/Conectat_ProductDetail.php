<?php
session_start();
require_once '../controllers/DetailController.php';
require_once '../controllers/CommentController.php';

// Verificăm dacă există un id de produs în parametrii GET
if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

// Verificăm dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to comment.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Inițializăm controller-ii
$detailController = new DetailController();
$commentController = new CommentController();

// Preluăm detalii despre produs și comentariile asociate
$product = $detailController->getProductDetail(intval($_GET['id']));
$comments = $commentController->getComments(intval($_GET['id']));

$countryCoordinates = [
    'Italy' => [41.87194, 12.56738],
    'Spain' => [40.463667, -3.74922],
    'France' => [46.603354, 1.888334],
    'Germany' => [51.165691, 10.451526],
    'Romania' => [45.943161, 24.96676]
];

$coordinates = isset($countryCoordinates[$product['country']]) ? $countryCoordinates[$product['country']] : [0, 0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../css/Conectat_ProductDetail.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div class="logo"><img src="../../img/Logo.png" alt="logo">Souvenirs<span>.</span></div>
    <input type="checkbox" id="toggler" class="toggler">
    <label for="toggler" class="toggler-icon">☰</label>

    <nav class="navbar">
        <ul class="navbar__links">
            <li class="navbar__links__item--link"><a href="Conectat_Home.php">Home</a></li>
            <li class="navbar__links__item--link"><a href="Conectat_VirtualMap.php">Virtual Map</a></li>
            <li class="navbar__links__item--link"><a href="Conectat_Category.php">Category</a></li>
        </ul>
    </nav>
    <div class="navbar__buttons">
        <input type="checkbox" id="user" class="user">
        <label for="user" class="user-icon"><a href="ProfilPagina.php"><img src="../../img/profile-user.png" alt="profile"></a></label>
    </div>
</header>
<div class="product-detail">
    <div class="product-image">
        <img src="uploaded_img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="product-info">
        <h1><?php echo $product['name']; ?></h1>
        <p>Period: <?php echo $product['period']; ?></p>
        <p>Receiver: <?php echo $product['receiver']; ?></p>
    </div>
    <div id="map"></div>
</div>

<div class="comments-section">
    <h2>Comments</h2>

    <form id="commentForm">
        <input type="hidden" id="product_id" name="product_id" value="<?php echo intval($_GET['id']); ?>">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
        <textarea id="comment" name="comment" placeholder="Add your comment" required></textarea>
        <button type="submit" class="submit-button">Submit</button>
    </form>

    <div id="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment" data-comment-id="<?php echo $comment['comment_id']; ?>">
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                <small>Posted by <?php echo htmlspecialchars($comment['username']); ?> on <?php echo $comment['created_at']; ?></small>
                <?php if ($comment['user_id'] == $user_id): ?>
                    <button class="delete-comment" data-comment-id="<?php echo $comment['comment_id']; ?>">Delete</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>



<footer class="footer">
    <div class="footer__content">
        <div class="footer__column">
            <h3>Contact</h3>
            <p>Adress: Street General Berthelot, Number 16, RO-700483 - Iaşi</p>
            <p>Email: contact@souvenirs.com</p>
            <p>Phone: 0232 20 1090; Fax: 0232 20 1490</p>
            <p>Social media</p>
            <div class="social-icons">
                <a href="#" target="_blank"><img src="../../img/facebook.png" alt="Facebook"></a>
                <a href="#" target="_blank"><img src="../../img/instagram.png" alt="Instagram"></a>
                <a href="#" target="_blank"><img src="../../img/tiktok.png" alt="TikTok"></a>
                <a href="#" target="_blank"><img src="../../img/twitter.png" alt="Twitter"></a>
            </div>
        </div>
        <div class="footer__column">
            <h3>Useful Links</h3>
            <div class="spacer"></div>
            <ul>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Privacy and Cookies Statement</a></li>
                <li><a href="AboutUs.php">About us</a></li>
                <li><a href="Help.php">Help</a></li>
            </ul>
        </div>
    </div>
    <div class="footer__copyright">
        <p>&copy; 2024 Souvenirs. All rights reserved.</p>
    </div>
</footer>

<script>
    var map = L.map('map').setView([<?php echo $coordinates[0]; ?>, <?php echo $coordinates[1]; ?>], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([<?php echo $coordinates[0]; ?>, <?php echo $coordinates[1]; ?>]).addTo(map)
        .bindPopup('<?php echo $product['country']; ?>')
        .openPopup();

    // AJAX pentru trimiterea comentariilor
    $(document).ready(function() {
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();
            var product_id = $('#product_id').val();
            var user_id = $('#user_id').val();
            var comment = $('#comment').val();

            $.ajax({
                type: 'POST',
                url: '../controllers/CommentController.php',
                data: {
                    action: 'addComment',
                    product_id: product_id,
                    user_id: user_id,
                    comment: comment
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var newComment = `
                        <div class="comment" data-comment-id="${data.comment_id}">
                            <p>${comment}</p>
                            <small>Posted by ${data.username} on ${data.timestamp}</small>
                            <button class="delete-comment" data-comment-id="${data.comment_id}">Delete</button>
                        </div>`;
                        $('#comments').append(newComment); // Append the new comment
                        $('#comment').val('');
                    } else {
                        alert('Failed to add comment.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error occurred while adding comment.');
                }
            });
        });

        $(document).on('click', '.delete-comment', function() {
            var commentId = $(this).data('comment-id');
            if (confirm('Are you sure you want to delete this comment?')) {
                $.ajax({
                    type: 'POST',
                    url: '../controllers/CommentController.php',
                    data: {
                        action: 'deleteComment',
                        comment_id: commentId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('div[data-comment-id="' + commentId + '"]').remove();
                        } else {
                            alert('Failed to delete comment.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while deleting comment.');
                    }
                });
            }
        });
    });


</script>

</body>
</html>
