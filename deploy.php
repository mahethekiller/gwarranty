<?php
// deploy.php
echo shell_exec('whoami');
$secret = 'your_webhook_secretmk'; // optional, used for security

// Validate GitHub signature (optional but recommended)
$headers = getallheaders();
$payload = file_get_contents('php://input');
$signature = 'sha256=' . hash_hmac('sha256', $payload, $secret, false);

if (!isset($headers['X-Hub-Signature-256']) || !hash_equals($signature, $headers['X-Hub-Signature-256'])) {
    http_response_code(403);
    exit('Access denied.');
}

// Run shell command to pull latest changes
$output = shell_exec('cd /home/yourcpaneluser/public_html && git pull 2>&1');

echo "<pre>$output</pre>";
?>
