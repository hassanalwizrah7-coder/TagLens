<?php
// TagLens: Cloud-Based Photo Album with AI Tagging
// Entry point for uploads and basic routing


require_once __DIR__ . '/aws.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/photo.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TagLens - Cloud Photo Album</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
</head>
<body>
<header>
    <h1>TagLens</h1>
    <p>Cloud-Based Photo Album with AI Tagging</p>
</header>
<div class="container">
    <form id="uploadForm" method="POST" enctype="multipart/form-data" action="?action=upload">
        <input type="file" name="photo" required />
        <button type="submit">Upload Photo</button>
    </form>
    <form id="searchForm" method="POST" action="?action=search" style="margin-top:1em;">
        <input type="text" name="tag" placeholder="Search by tag..." />
        <button type="submit">Search</button>
    </form>
    <div id="result">
        <?php
        $action = $_GET['action'] ?? '';
        switch ($action) {
            case 'upload':
                handle_upload();
                break;
            case 'search':
                handle_search();
                break;
            case 'share':
                handle_share();
                break;
            default:
                echo "<p>Upload a photo or search by tag.</p>";
                break;
        }
        ?>
    </div>
</div>
</body>
</html>
