<?php
require_once '../models/Favorite.php';

class FavoriteController {
    private $favorite;

    public function __construct() {
        $this->favorite = new Favorite();
    }

    public function toggleFavorite($userId, $productId) {
        if ($this->validateIds($userId, $productId)) {
            if ($this->favorite->isFavorite($userId, $productId)) {
                // Dacă este deja favorit, elimină din favorite
                $this->favorite->removeFavorite($userId, $productId);
                return false; // Produsul a fost șters din favorite
            } else {
                // Dacă nu este favorit, adaugă în favorite
                $this->favorite->addFavorite($userId, $productId);
                return true; // Produsul a fost adăugat în favorite
            }
        }
        return false;
    }



    public function getUserFavorites($userId) {
        if (is_int($userId) && $userId > 0) {
            return $this->favorite->getUserFavorites($userId);
        }
        return [];
    }

    public function isFavorite($userId, $productId) {
        if ($this->validateIds($userId, $productId)) {
            return $this->favorite->isFavorite($userId, $productId);
        }
        return false;
    }

    private function validateIds($userId, $productId) {
        return is_int($userId) && $userId > 0 && is_int($productId) && $productId > 0;
    }
}
?>
