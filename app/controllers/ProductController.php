<?php

class ProductController extends Controller
{
    public function index(int $page = 1): void
    {
        $product = new Product();
        $category = new Category();
        $vendorModel = new Vendor();
        $filters = [
            'q' => $_GET['q'] ?? '',
            'category_id' => isset($_GET['category_id']) ? (int)$_GET['category_id'] : null,
            'min' => $_GET['min'] ?? null,
            'max' => $_GET['max'] ?? null,
            'brand' => $_GET['brand'] ?? null,
            'vendor_id' => isset($_GET['vendor_id']) ? (int)$_GET['vendor_id'] : null,
            'min_rating' => isset($_GET['min_rating']) ? (float)$_GET['min_rating'] : null,
        ];
        $result = $product->paginate($page, 12, $filters);
        $categories = $category->all();
        $vendors = $vendorModel->approved();
        $title = 'Products';
        if (!empty($filters['q'])) { $title .= ' • Search: ' . $filters['q']; }
        $meta_description = 'Browse products with filters for category, price, brand, vendor, and rating.';
        $this->view('products/index', [
            'products' => $result['items'],
            'pagination' => $result,
            'categories' => $categories,
            'vendors' => $vendors,
            'filters' => $filters,
            'title' => $title,
            'meta_description' => $meta_description,
        ]);
    }

    public function detail(int $id): void
    {
        $productModel = new Product();
        $product = $productModel->find($id);
        if (!$product) {
            http_response_code(404);
            echo 'Product not found';
            return;
        }
        $images = json_decode($product['images'] ?? '[]', true) ?: [];
        $related = $productModel->related((int)$product['id'], isset($product['category_id']) ? (int)$product['category_id'] : null, 6);
        $reviews = (new Review())->forProduct((int)$product['id']);
        $wishlisted = false;
        if ($u = current_user()) {
            if (($u['role'] ?? '') === 'customer') {
                $wishlisted = (new Wishlist())->isInWishlist((int)$u['id'], (int)$product['id']);
            }
        }
        $title = $product['name'] . ' • ' . ($product['shop_name'] ?? 'Vendor');
        $meta_description = substr(strip_tags($product['description'] ?? ''), 0, 150);
        $meta_image = $images[0] ?? null;
        $this->view('products/detail', compact('product', 'images', 'related', 'reviews', 'wishlisted', 'title', 'meta_description', 'meta_image'));
    }

    public function search(): void
    {
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        $data = (new Product())->paginate(1, 8, ['q' => $q]);
        echo json_encode(['items' => $data['items']]);
    }

    public function addReview(int $id): void
    {
        require_login('customer');
        if (!is_post()) { redirect('product/detail/' . $id); }
        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $comment = trim($_POST['comment'] ?? '');
        (new Review())->add((int)$id, (int)current_user()['id'], $rating, $comment);
        flash('success', 'Thank you for your review!');
        redirect('product/detail/' . $id);
    }
}
