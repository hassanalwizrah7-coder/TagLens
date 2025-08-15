- [x] Clarify Project Requirements
- [ ] Scaffold the Project
- [ ] Customize the Project
- [ ] Install Required Extensions
- [ ] Compile the Project
- [ ] Create and Run Task
- [ ] Launch the Project
- [ ] Ensure Documentation is Complete

## Project Requirements
PHP project named TagLens for a cloud-based photo album with AI tagging. Features:
- Users upload photos
- AI tags images by people/objects/locations using AWS Rekognition
- Images stored in S3
- Metadata in DynamoDB
- CloudFront for global delivery
- Cognito for authentication
- Lambda for image resizing/optimization
- SNS for sharing notifications

AWS Architecture:
- Serverless image processing: S3 triggers Lambda to process/resize images, store in another S3 bucket
- Optional API Gateway for uploads
- DynamoDB for metadata
- Step Functions for workflows
- Emphasize event-driven, cost-efficient, secure serverless design.
