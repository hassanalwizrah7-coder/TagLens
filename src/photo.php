<?php
// Photo handling logic for TagLens
require_once __DIR__ . '/aws.php';
require_once __DIR__ . '/auth.php';


function handle_upload() {
    if (!is_authenticated()) {
        echo "<p>Authentication required.</p>";
        return;
    }
    if (!isset($_FILES['photo'])) {
        echo "<p>No photo uploaded.</p>";
        return;
    }
    $file = $_FILES['photo']['tmp_name'];
    $key = basename($_FILES['photo']['name']);
    $imageBytes = file_get_contents($file);
    $labels = detect_labels($imageBytes);
    $url = upload_to_s3($file, $key);
    store_metadata(['key' => $key, 'labels' => $labels]);
    echo "<div><img src='$url' style='max-width:100%;border-radius:6px;' alt='Uploaded Photo'/></div>";
    echo "<div class='tags'><strong>Tags:</strong> ";
    foreach ($labels as $tag) {
        echo "<span class='tag'>$tag</span> ";
    }
    echo "</div>";
}

function handle_search() {
    if (!is_authenticated()) {
        echo "<p>Authentication required.</p>";
        return;
    }
    $tag = $_POST['tag'] ?? '';
    if (!$tag) {
        echo "<p>Please enter a tag to search.</p>";
        return;
    }
    $ddb = getDynamoDbClient();
    $table = 'your-photo-metadata-table'; // Replace with your table name
    $result = $ddb->scan([
        'TableName' => $table,
        'FilterExpression' => 'contains(labels, :tag)',
        'ExpressionAttributeValues' => [':tag' => ['S' => $tag]],
    ]);
    if (empty($result['Items'])) {
        echo "<p>No photos found for tag: $tag</p>";
        return;
    }
    echo "<div><strong>Results for tag: $tag</strong></div>";
    foreach ($result['Items'] as $item) {
        $key = $item['key']['S'];
        $url = "https://your-photo-bucket.s3.amazonaws.com/$key"; // Replace with your bucket name
        echo "<div style='margin-bottom:1em;'><img src='$url' style='max-width:100%;border-radius:6px;' alt='Photo'/></div>";
    }
}

function handle_share() {
    if (!is_authenticated()) {
        echo "<p>Authentication required.</p>";
        return;
    }
    send_sns_notification('Photo shared!');
    echo "<p>Photo shared and notification sent.</p>";
}

// ...existing code...
