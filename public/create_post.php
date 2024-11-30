<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Submission Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2Yh6x1fEg8gTx7MtfiWfY7Hd37dPT6-lk4w&s');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            background-color: aliceblue;
            max-height: 600px;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="text-center mb-4">Create New Post</h2>
        <form action="../controllers/PostController.php" method="POST" enctype="multipart/form-data" onsubmit="confirmSubmission(event)">
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Enter post title" required>
            </div>

            <div class="mb-3">
                <label for="postContent" class="form-label">Post Content</label>
                <textarea class="form-control" id="postContent" name="postContent" rows="5" placeholder="Enter post content" required></textarea>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option selected>Choose role...</option>
                    <option value="Worker">Worker</option>
                    <option value="Employer">Employer</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="field" class="form-label">Field</label>
                <select class="form-select" id="field" name="field" required>
                    <option selected>Choose field...</option>
                    <option value="Gardener">Gardener</option>
                    <option value="Cleaner">Cleaner</option>
                    <option value="Mover">Mover</option>
                    <option value="Driver">Driver</option>
                    <option value="Nanny">Nanny</option>
                    <option value="Plantcare">Plant Care</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="priceRange" class="form-label">Price</label>
                <div class="d-flex">
                    <input type="number" class="form-control me-2" id="priceFrom" name="priceFrom" placeholder="Price" min="100" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="goi" class="form-label">Chọn gói</label>
                <select class="form-select" id="goi" name="goi" required>
                    <option selected>Chọn gói</option>
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                    <option value="Vip">Vip</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" pattern="[0-9]{10}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" id="location" name="location" required>
                    <option selected>Choose location...</option>
                    <option value="Son Tra">Son Tra</option>
                    <option value="Cam Le">Cam Le</option>
                    <option value="Hoa Vang">Hoa Vang</option>
                    <option value="Ngu Hanh Son">Ngu Hanh Son</option>
                    <option value="Lien Chieu">Lien Chieu</option>
                    <option value="Thanh Khue">Thanh Khue</option>
                    <option value="Hai Chau">Hai Chau</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="postImage" class="form-label">Upload Image</label>
                <input class="form-control" type="file" id="postImage" name="postImage">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success text-white">Submit Post</button>
            </div>
        </form>
    </div>

</body>

</html>
