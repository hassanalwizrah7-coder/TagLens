<?php
// AWS SDK configuration for TagLens
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;
use Aws\DynamoDb\DynamoDbClient;
use Aws\Sns\SnsClient;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

function getS3Client() {
    return new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-1',
        // 'credentials' => [...], // Add credentials or use IAM roles
    ]);
}

function getRekognitionClient() {
    return new RekognitionClient([
        'version' => 'latest',
        'region'  => 'us-east-1',
    ]);
}

function getDynamoDbClient() {
    return new DynamoDbClient([
        'version' => 'latest',
        'region'  => 'us-east-1',
    ]);
}

function getSnsClient() {
    return new SnsClient([
        'version' => 'latest',
        'region'  => 'us-east-1',
    ]);
}

function getCognitoClient() {
    return new CognitoIdentityProviderClient([
        'version' => 'latest',
        'region'  => 'us-east-1',
    ]);
}
