<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $product = new Product();
        $category = new Category();
        $featured = $product->featured(8);
        $categories = $category->all();
        $this->view('home', compact('featured', 'categories'));
    }
}
