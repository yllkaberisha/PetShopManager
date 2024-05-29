<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- product CRUD section starts  -->

    <section class="add-products">
        <h1 class="title">Shop Products</h1>

        <form id="addProductForm" enctype="multipart/form-data">
            <h3>Add Product</h3>
            <input type="text" name="name" class="box" placeholder="Enter product name" required>
            <input type="number" min="0" name="price" class="box" placeholder="Enter product price" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="button" value="Add Product" onclick="addProduct()" class="btn">
        </form>
    </section>

    <!-- product CRUD section ends -->

    <!-- show products  -->

    <section class="show-products">
        <!--Metoda per sortim -->
        <div class="sort-dropdown">
            <form id="sortForm">
                <label for="sort">Sort by:</label>
                <select id="sort" name="sort_order" onchange="sortProducts()">
                    <option value="az">Name (A-Z)</option>
                    <option value="za">Name (Z-A)</option>
                    <option value="high-low">Price (High-Low)</option>
                    <option value="low-high">Price (Low-High)</option>
                </select>
            </form>
        </div>

        <div id="productsContainer" class="box-container">
            <!-- Products will be loaded here using AJAX -->
        </div>
    </section>

    <!-- Edit product form -->
    <section class="edit-product-form" style="display: none;">
        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" id="update_p_id">
            <input type="hidden" name="update_old_image" id="update_old_image">
            <img src="" id="current_image" alt="">
            <input type="text" name="update_name" id="update_name" class="box" required
                placeholder="Enter product name">
            <input type="number" name="update_price" id="update_price" min="0" class="box" required
                placeholder="Enter product price">
            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="button" value="Update" onclick="updateProduct()" class="btn">
            <input type="reset" value="Cancel" id="close-update" class="option-btn" onclick="closeEditForm()">
        </form>
    </section>

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

    <script>
        function addProduct() {
            var formData = new FormData($('#addProductForm')[0]);
            $.ajax({
                url: 'ajax/add_product.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        $('#addProductForm')[0].reset();
                        loadProducts(); // Load products again to reflect the new addition
                    }
                }
            });
        }

        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: 'ajax/delete_product.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        var res = JSON.parse(response);
                        alert(res.message);
                        if (res.status === 'success') {
                            loadProducts(); // Load products again to reflect the deletion
                        }
                    }
                });
            }
        }

        function editProduct(id) {
            $.ajax({
                url: 'ajax/get_product.php',
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('#update_p_id').val(response.id);
                    $('#update_name').val(response.name);
                    $('#update_price').val(response.price);
                    $('#update_old_image').val(response.image);
                    $('#current_image').attr('src', 'uploaded_img/' + response.image);
                    $('.edit-product-form').show();
                }
            });
        }

        function updateProduct() {
            var formData = new FormData($('#editForm')[0]);
            $.ajax({
                url: 'ajax/update_product.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        loadProducts(); // Load products again to reflect the update
                        closeEditForm();
                    }
                }
            });
        }

        function closeEditForm() {
            $('.edit-product-form').hide();
        }

        function loadProducts(sortOrder = 'az') {
            $.ajax({
                url: 'ajax/load_products.php',
                type: 'GET',
                data: { sort_order: sortOrder },
                success: function (response) {
                    $('#productsContainer').html(response);
                    $('#sort').val(sortOrder); // Set the selected sort option
                }
            });
        }

        function sortProducts() {
            var sortOrder = $('#sort').val();
            loadProducts(sortOrder); // Load products based on selected sort order
        }

        $(document).ready(function () {
            loadProducts(); // Load products when the page is ready
        });
    </script>

</body>

</html>