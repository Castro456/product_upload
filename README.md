# Product Details

## Form Creation
- Created a custom form in Laravel to collect the Product name, Price, SKU, Description, and Images.
- Enabled multiple file uploads (JPEG, PNG only) with a preview panel.
- Included a button to clear all preview images in a single click.

## Field Validation and Security Measures
- Used Laravel validations to ensure all values are filled.
- Implemented a try-catch block for error handling.

## Email Sending and Database Integration
- Configured the form to send details to the admin user via email with attachments once saved by the customer.
- Implemented a queue for sending an email to the admin regarding the new product registration details along with its attachments.
- Saved the form details in the database.

## API Creation
- Created an API to save the product details to the database. `APIProductController`

## Display and Data Management
- Displayed all the product details on the front page.
- Added an export button for exporting product details into an Excel file.
- Added an import button for importing product details from an Excel file into the database.

## Note
- I have not included the .env file because I am using Mailtrap for email configuration.
