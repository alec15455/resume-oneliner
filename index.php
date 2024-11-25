<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

// Initialize Stripe
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_checkout':
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => 1000,
                            'product_data' => [
                                'name' => 'Resume One-Liner Optimization',
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => SITE_URL . '/index.php?success=true&session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => SITE_URL . '/index.php?canceled=true',
                ]);
                echo json_encode(['id' => $session->id]);
                exit;
        }
    }
}

$showForm = isset($_GET['success']) && $_GET['success'] === 'true';
$sessionId = $showForm ? $_GET['session_id'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume One-Liner | Get a Powerful Resume Line for $10</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if ($showForm): ?>
            <div class="success-message">
                Payment successful! Please submit your current resume line below.
            </div>
            <div class="form-group">
                <h2>Submit Your Current Resume Line</h2>
                <textarea id="current-line" placeholder="Paste your current resume line or achievement here..."></textarea>
            </div>
            <button class="button" id="submit-line">Submit</button>
        <?php else: ?>
            <h1>Get One Powerful Line for Your Resume</h1>
            
            <p>I'll transform your achievement into one compelling line that makes recruiters want to interview you.</p>
            
            <div class="price">$10</div>
            
            <ul>
                <li>✓ Custom-written for your specific experience</li>
                <li>✓ Optimized for ATS systems</li>
                <li>✓ Delivered within 24 hours</li>
                <li>✓ One revision included</li>
            </ul>

            <button id="checkout-button" class="button">Get Your Power Line Now</button>
            
            <div class="testimonial">
                "Transformed my vague job description into something that actually shows my impact!" - Alex S.
            </div>
            
            <div class="guarantee">
                <strong>Money-Back Guarantee:</strong> Not happy? Full refund, no questions asked.
            </div>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
