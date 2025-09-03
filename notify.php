<?php
// This is a placeholder for the Instant Transaction Notification (ITN) handler.
// In a real application, you would have logic here to:
// 1. Receive the POST data from PayFast.
// 2. Validate the data source and signature to ensure data integrity.
// 3. Check the payment status.
// 4. Update your database (e.g., mark an order as paid).
// 6. Respond with a 200 OK header to acknowledge receipt.

// For now, we'll just log the request to a file for debugging.
file_put_contents('itn_log.txt', "ITN Received: " . date('Y-m-d H:i:s') . "\n" . print_r($_POST, true), FILE_APPEND);

header("HTTP/1.1 200 OK");
?>