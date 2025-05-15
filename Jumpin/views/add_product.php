<?php include '../includes/header.php'; ?>

<div class="container mt-5 mb-3" style="max-width: 600px;">
  <h2 class="mb-4">Add New Product</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="AddProduct.php">
    <div class="mb-3">
      <label for="vendor_id" class="form-label">Vendor ID <span class="text-danger">*</span></label>
      <input type="number" class="form-control" id="vendor_id" name="vendor_id" required min="1" value="<?= isset($_POST['vendor_id']) ? intval($_POST['vendor_id']) : '' ?>">
    </div>

    <div class="d-flex flex-column mb-3">
      <label for="brand_id" class="form-label ">Brand</label>
      <select class="form-select w-100" id="brand_id" name="brand_id">
        <option value="">-- Select Brand (optional) --</option>
        <?php while ($brand = $brands->fetch_assoc()): ?>
          <option value="<?= $brand['brand_id'] ?>" <?= (isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['brand_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($brand['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="name" name="name" required maxlength="255" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
      <input type="number" class="form-control" id="price" name="price" required step="0.01" min="0" value="<?= isset($_POST['price']) ? floatval($_POST['price']) : '' ?>">
    </div>

    <div class="mb-3">
      <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="size" name="size" required maxlength="50" value="<?= isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '' ?>">
    </div>

    <div class="mb-3">
      <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
      <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required min="0" value="<?= isset($_POST['stock_quantity']) ? intval($_POST['stock_quantity']) : '' ?>">
    </div>

    <div class="mb-3">
      <label for="imageName1" class="form-label">Image Name 1</label>
      <input type="text" class="form-control" id="imageName1" name="imageName1" maxlength="255" value="<?= isset($_POST['imageName1']) ? htmlspecialchars($_POST['imageName1']) : '' ?>">
    </div>

    <div class="mb-3">
      <label for="imageName2" class="form-label">Image Name 2</label>
      <input type="text" class="form-control" id="imageName2" name="imageName2" maxlength="255" value="<?= isset($_POST['imageName2']) ? htmlspecialchars($_POST['imageName2']) : '' ?>">
    </div>

    <button type="submit" class="btn btn-primary">Add Product</button>
    <a href="../admin/products.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
<?php include '../includes/admin_footer.php'; ?>
