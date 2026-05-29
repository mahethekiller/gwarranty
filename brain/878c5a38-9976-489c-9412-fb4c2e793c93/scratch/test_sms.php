<?php

require __DIR__ . '/../../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Helpers\SMSHelper;
use Illuminate\Support\Facades\Http;

// Mock Http
Http::fake([
    'https://bulksms.analyticsmantra.com/*' => Http::response(['status' => 'success'], 200),
]);

$phone = "9125367540";
$message = "Test Message for Warranty";

echo "Testing SMS sending...\n";
$response = SMSHelper::sendSMS($phone, $message);

echo "Response Body: " . $response->getContent() . "\n";

Http::assertSent(function ($request) use ($phone, $message) {
    return strpos($request->url(), 'https://bulksms.analyticsmantra.com/sendsms/sendsms.php') !== false &&
           $request['mobile'] == $phone &&
           $request['message'] == $message &&
           $request['username'] == 'greenlam' &&
           !isset($request['templateId']);
});

echo "Verification Successful: SMS request constructed correctly without templateId.\n";
