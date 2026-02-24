<?php

class WishlistController extends Controller
{
    public function index(): void
    {
        require_login('customer');
        $user = current_user();
        $items = (new Wishlist())->allForCustomer((int)$user['id']);
        $this->view('wishlist/index', compact('items'));
    }

    public function add(int $productId): void
    {
        require_login('customer');
        (new Wishlist())->add((int)current_user()['id'], (int)$productId);
        flash('success', 'Added to wishlist');
        if (!empty($_SERVER['HTTP_REFERER'])) { header('Location: ' . $_SERVER['HTTP_REFERER']); exit; }
        redirect('wishlist');
    }

    public function remove(int $productId): void
    {
        require_login('customer');
        (new Wishlist())->remove((int)current_user()['id'], (int)$productId);
        flash('success', 'Removed from wishlist');
        if (!empty($_SERVER['HTTP_REFERER'])) { header('Location: ' . $_SERVER['HTTP_REFERER']); exit; }
        redirect('wishlist');
    }
}
