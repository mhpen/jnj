<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional and Aesthetic Content Area</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="adminStyle.css">
    <style>
        /* Add your custom styles here */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .main {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            width: 300px;
            margin-right: 0px; /* Adjusted margin */
        }

        .search-input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
        }

        .search-btn {
            background-color: #8b5d2e;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ccc; /* Add border */
        }

        .categories-table th,
        .categories-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .categories-table th {
            background-color: #f2f2f2;
        }

        .categories-table tbody tr:hover {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            align-items: center; /* Align items vertically */
        }

        .edit-icon,
        .delete-icon {
            color: brown;
            cursor: pointer;
        }

        /* Modal styles */
        .modal-backdrop {
            backdrop-filter: blur(5px);
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">J&J</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Product Management </span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Product</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Inventory</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Orders and Payment</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                Two Links
                            </a>
                            <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 1</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Chats</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
            <div class="text-center">
                <h1>Category</h1>
            </div>
            <div class="content-header">
                <button class="btn btn-primary add-button"><i class="lni lni-plus"></i></button>
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    <!-- Categories will be dynamically added here -->
                    <?php
                    // Sample PHP code for displaying categories
                    $categories = [
                        ["CategoryName" => "Category 1", "CategoryID" => 1],
                        ["CategoryName" => "Category 2", "CategoryID" => 2],
                    ];

                    foreach ($categories as $category) {
                        echo "<tr>";
                        echo "<td>" . $category['CategoryName'] . "</td>";
                        echo "<td>" . $category['CategoryID'] . "</td>";
                        echo "<td class='actions'>";
                        echo "<i class='lni lni-pencil edit-icon' onclick='editCategory(" . $category['CategoryID'] . ", \"" . $category['CategoryName'] . "\")'></i>";
                        echo "<i class='fas fa-trash-alt delete-icon' onclick='deleteCategory(" . $category['CategoryID'] . ")'></i>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal fade" id="addCategoryModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="categoryName" class="form-control" placeholder="Enter category name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveCategory">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="confirmationModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this category?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmDelete">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editCategoryModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="editCategoryName" class="form-control" placeholder="Enter new category name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveEditedCategory">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById('saveCategory').addEventListener('click', function () {
            var categoryName = document.getElementById('categoryName').value;
            // Simulated AJAX call
            setTimeout(function () {
                // Close modal
                var addCategoryModal = new bootstrap.Modal(document.getElementById("addCategoryModal"));
                addCategoryModal.hide();
                // Show success notice
                alert("Category added successfully!");
                // Clear input field
                document.getElementById('categoryName').value = '';
            }, 1000); // Simulate response time of 1 second
        });

        fetch('fetch_categories.php')
        .then(response => response.json())
        .then(categories => {
            const categoryTableBody = document.getElementById('categoryTableBody');
            categories.forEach(category => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${category.CategoryName}</td>
                    <td>${category.CategoryID}</td>
                    <td class="actions">
                        <i class="lni lni-pencil edit-icon"></i>
                        <i class="fas fa-trash-alt edit-icon"></i>
                    </td>
                `;
                categoryTableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
        // Function to handle deleting a category
        function deleteCategory(categoryId) {
            // Show confirmation modal
            var confirmationModal = new bootstrap.Modal(document.getElementById("confirmationModal"));
            confirmationModal.show();

            // Handle confirmation
            document.getElementById('confirmDelete').addEventListener('click', function () {
                // Simulated AJAX call for deletion
                setTimeout(function () {
                    // Redirect to a PHP file to handle deletion
                    window.location.href = "delete_category.php?id=" + categoryId;
                }, 1000); // Simulate response time of 1 second
            });
        }

        // Function to handle editing a category
        function editCategory(categoryId, currentName) {
            // Show edit modal
            var editCategoryModal = new bootstrap.Modal(document.getElementById("editCategoryModal"));
            editCategoryModal.show();

            // Set current category name in the input field
            document.getElementById('editCategoryName').value = currentName;

            // Handle saving edited category
            document.getElementById('saveEditedCategory').addEventListener('click', function () {
                var newName = document.getElementById('editCategoryName').value;
                // Simulated AJAX call for editing
                setTimeout(function () {
                    // Redirect to a PHP file to handle editing
                    window.location.href = "edit_category.php?id=" + categoryId + "&name=" + newName;
                }, 1000); // Simulate response time of 1 second
            });
        }

        const hamBurger = document.querySelector(".toggle-btn");
        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });

        const addBtn = document.querySelector(".add-button");
        addBtn.addEventListener("click", function () {
            // Show the modal when Add button is clicked
            const addCategoryModal = new bootstrap.Modal(document.getElementById("addCategoryModal"));
            addCategoryModal.show();
        });
    </script>
</body>
</html>