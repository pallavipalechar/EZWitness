<?php
$imageFolder = 'images/';
$images = glob($imageFolder . '*.{jpg,png,gif}', GLOB_BRACE);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery</title>
    <style>
        .image-container {
            display: flex;
            flex-direction: row;
            max-height: 400px;
            overflow-y: auto;
        }

        .image-item {
            margin: 10px;
            display: flex;
            justify-content: space-between; /* Add spacing between image and delete button */
            align-items: center; /* Vertically center items */
        }

        .image-item img {
            max-width: 200px;
            max-height: 200px;
        }

        .delete-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div>
    <?php
    $imageFolder = 'onboard_img/';
    $images = glob($imageFolder . '*.{jpg,png,gif}', GLOB_BRACE);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
        $imageToDelete = $_POST['delete_image'];
        if (file_exists($imageToDelete)) {
            unlink($imageToDelete); // Delete the selected image
            // Refresh the list of images
            $images = glob($imageFolder . '*.{jpg,png,gif}', GLOB_BRACE);
        }
    }
    ?>

   

    <div class="image-container">
        <?php foreach ($images as $image): ?>
            <div class="image-item">
                <img src="<?php echo $image; ?>" alt="Image">
                <span class="delete-button" data-image="<?php echo $image; ?>">Delete</span>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var deleteButtons = document.querySelectorAll(".delete-button");
            deleteButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var imageToDelete = this.getAttribute("data-image");
                    if (confirm("Are you sure you want to delete this image?")) {
                        // Submit a form with the image path to delete it
                        var form = document.createElement("form");
                        form.method = "post";
                        form.action = "";
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "delete_image";
                        input.value = imageToDelete;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
</div>

</body>
</html>
