<?php

require_once __DIR__ . '/aws_config.php';

function upload_to_s3($filePath, $key) {
    $s3 = getS3Client();
    $bucket = 'your-photo-bucket'; // Replace with your bucket name
    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $filePath,
            'ACL' => 'public-read',
        ]);
        return $result['ObjectURL'];
    } catch (Exception $e) {
        return false;
    }
}

function detect_labels($imageBytes) {
    $rekognition = getRekognitionClient();
    try {
        $result = $rekognition->detectLabels([
            'Image' => ['Bytes' => $imageBytes],
            'MaxLabels' => 10,
            'MinConfidence' => 70,
        ]);
        $labels = array_map(function($label) {
            return $label['Name'];
        }, $result['Labels']);
        return $labels;
    } catch (Exception $e) {
        return [];
    }
}

function store_metadata($metadata) {
    $ddb = getDynamoDbClient();
    $table = 'your-photo-metadata-table'; // Replace with your table name
    try {
        $ddb->putItem([
            'TableName' => $table,
            'Item' => [
                'key' => ['S' => $metadata['key']],
                'labels' => ['SS' => $metadata['labels']],
            ],
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function send_sns_notification($message) {
    $sns = getSnsClient();
    $topicArn = 'your-sns-topic-arn'; // Replace with your SNS topic ARN
    try {
        $sns->publish([
            'TopicArn' => $topicArn,
            'Message' => $message,
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// ...existing code...
