<?php
require_once '../config/database.php';
require_once '../models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ProductModel($conn);
    }

    public function getProductDetails($productId) {
        // Get product details with the brand
        $product = $this->productModel->getProductWithBrand($productId);

        if ($product) {
            return $product;  // Return product details to the view
        }

        return null;  // Handle case where no product is found
    }
}
