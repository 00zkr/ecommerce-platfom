<?php include '../includes/admin_header.php'; ?>

<div class="container mt-5 mb-3">
    <h2>Edit Product #<?= htmlspecialchars($product['product_id']) ?></h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required />
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input id="price" name="price" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required />
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input id="size" name="size" class="form-control" value="<?= htmlspecialchars($product['size']) ?>" required />
        </div>
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input id="stock_quantity" name="stock_quantity" type="number" class="form-control" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required />
        </div>
        <div class="mb-3">
            <label for="imageName1" class="form-label">Image 1 Filename</label>
            <input id="imageName1" name="imageName1" class="form-control" value="<?= htmlspecialchars($product['imageName1']) ?>" />
        </div>
        <div class="mb-3">
            <label for="imageName2" class="form-label">Image 2 Filename</label>
            <input id="imageName2" name="imageName2" class="form-control" value="<?= htmlspecialchars($product['imageName2']) ?>" />
        </div>
        <div class="d-flex flex-column mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <select id="brand_id" name="brand_id" class="form-select">
                <option value="">-- Select Brand (optional) --</option>
                <?php
                $brandsResult->data_seek(0);
                while ($brand = $brandsResult->fetch_assoc()): ?>
                    <option value="<?= $brand['brand_id'] ?>" <?= ($brand['brand_id'] == $product['brand_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Update Product</button>
        <a href="../views/all_products.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<!-- Optional Bootstrap JS if needed -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/admin_footer.php'; ?>
