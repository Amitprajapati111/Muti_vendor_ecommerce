<?php

class CartController extends Controller
{
    private function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    private function saveCart(array $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    public function index(): void
    {
        $cart = $this->getCart();
        $this->view('cart/index', compact('cart'));
    }

    public function add(): void
    {
        if (!is_post()) { redirect('cart'); }
        $id = (int)($_POST['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['qty'] ?? 1));
        $product = (new Product())->find($id);
        if (!$product) { flash('error', 'Product not found'); redirect('cart'); }
        $cart = $this->getCart();
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => (float)$product['price'],
                'qty' => 0,
            ];
        }
        $cart[$id]['qty'] += $qty;
        $this->saveCart($cart);
        flash('success', 'Added to cart');
        redirect('cart');
    }

    public function update(): void
    {
        if (!is_post()) { redirect('cart'); }
        $cart = $this->getCart();
        foreach (($_POST['qty'] ?? []) as $id => $qty) {
            $id = (int)$id; $qty = max(0, (int)$qty);
            if ($qty === 0) { unset($cart[$id]); }
            else if (isset($cart[$id])) { $cart[$id]['qty'] = $qty; }
        }
        $this->saveCart($cart);
        flash('success', 'Cart updated');
        redirect('cart');
    }

    public function checkout(): void
    {
        require_login('customer');
        $cart = $this->getCart();
        if (!$cart) { flash('error', 'Your cart is empty'); redirect('cart'); }
        $this->view('cart/checkout', compact('cart'));
    }

    public function placeOrder(): void
    {
        require_login('customer');
        if (!is_post()) { redirect('cart/checkout'); }
        $cart = $this->getCart();
        if (!$cart) { redirect('cart'); }

        $total = 0.0;
        foreach ($cart as $item) { $total += $item['price'] * $item['qty']; }

        $orderModel = new Order();
        $orderId = $orderModel->create((int)current_user()['id'], $total, 'pending');
        foreach ($cart as $item) {
            $orderModel->addItem($orderId, (int)$item['id'], (int)$item['qty'], (float)$item['price']);
        }
        $this->saveCart([]);
        flash('success', 'Order placed successfully (COD). Order ID: #' . $orderId);
        redirect('home');
    }
}
