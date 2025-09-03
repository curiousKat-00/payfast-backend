<?php
// Get frontend URL from environment variables for CORS, with a local fallback.
$frontend_url = getenv('FRONTEND_URL') ?: 'http://localhost:3000';

// Set all headers, including the dynamic CORS header.
header("Access-Control-Allow-Origin: " . $frontend_url);
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// --- CONFIGURATION ---
// Use environment variables for production, with local fallbacks.
// These will be set in the Render dashboard.
$merchant_id = getenv('PAYFAST_MERCHANT_ID') ?: '10037484';
$merchant_key = getenv('PAYFAST_MERCHANT_KEY') ?: 'gl7ggaewzav2a';
$passphrase = getenv('PAYFAST_PASSPHRASE') ?: 'Work_2000100';
 
$backend_url = getenv('BACKEND_URL') ?: 'http://localhost:8000';
 
// PayFast URL
$is_sandbox = true;
$payfast_url = $is_sandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
 
// --- PAYMENT DATA ---
// URLs for redirection after payment
// These now use the dynamic URLs defined above.
$return_url = $frontend_url . '/payment-success';
$cancel_url = $frontend_url . '/payment-cancelled';
$notify_url = $backend_url . '/notify.php'; // The path will be simpler on Render
 
// Transaction details
$data = [
    'merchant_id' => $merchant_id,
    'merchant_key' => $merchant_key,
    'return_url' => $return_url,
    'cancel_url' => $cancel_url,
    'notify_url' => $notify_url,
    // Buyer details (optional)
    'name_first' => 'Test',
    'name_last'  => 'User',
    'email_address' => 'test@example.com',
    // Transaction details
    'm_payment_id' => 'TEST-'.uniqid(), // A unique payment ID from your system
    'amount' => '25.00',
    'item_name' => 'React Integration Test',
    'item_description' => 'A test payment for the React and PHP integration.',
];

// --- SIGNATURE GENERATION ---
$signature_data = $data;
// If a passphrase is set, append it to the data string for signing
if (!empty($passphrase)) {
    $signature_data['passphrase'] = $passphrase;
}

// Create the signature string and generate the hash
$signature_string = http_build_query($signature_data);
$signature = md5($signature_string);

// Add the signature to the form data
$data['signature'] = $signature;

// --- SEND RESPONSE ---
// Package everything into a single JSON object for the frontend
echo json_encode(['payfastUrl' => $payfast_url, 'formData' => $data]);
?>