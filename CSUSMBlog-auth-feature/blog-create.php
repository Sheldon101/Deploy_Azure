<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home-style.css">
    <title>Create Post</title>
</head>
<body>
    <div class="root">
        <header class="header">
            <a href="blog-home.php" class="logo"><span>CSUSM</span>Blog</a>
            <nav class="navbar">
                <a href="blog-home.php">Home</a>
                <?php if (isset($_SESSION['username']) && isset($_SESSION['adminId'])): ?>
                    <a href="user-logout.php">Logout</a>
                <?php else: ?>
                    <a href="loginForm.html">Login</a>
                <?php endif; ?>
            </nav>
        </header>

        <?php if (isset($_SESSION['username']) && isset($_SESSION['adminId'])): ?>
            <form action="create-blog-post.php" method="post" enctype="multipart/form-data" id="create-post-form">
                <h1>Create a post</h1>
                <div class="create-post-form-item">
                    <label for="title" class="create-post-input-label">Title:</label>
                    <input type="text" id="title" name="title" placeholder="Title..." class="create-post-input">
                </div>
                <div class="create-post-form-item">
                    <label for="subtitle" class="create-post-input-label">Subtitle:</label>
                    <input type="text" id="subtitle" name="subtitle" placeholder="Subtitle..." class="create-post-input">
                </div>

                <div class="create-post-form-item">
                    <label for="content" class="create-post-input-label">Content:</label>
                    <textarea id="content" name="content" rows="10" cols="30" required></textarea>
                </div>

                <div class="create-post-form-item">
                    <label for="thumbnail" class="create-post-input-label">Thumbnail URL:</label>
                    <input type="text" id="thumbnail" name="thumbnail" placeholder="Thumbnail URL..." class="create-post-input">
                </div>
                <button id="create-post-submit-button" type="submit">Create</button>
            </form>
        <?php else: ?>
            <p>Not logged in. Need to log in.</p>
        <?php endif; ?>
    </div>
</body>
</html>
