<?php
// Configuration
define('STRIPE_SECRET_KEY', 'sk_test_YOUR_KEY');
define('STRIPE_PUBLIC_KEY', 'pk_test_YOUR_KEY');
define('SITE_URL', 'http://yourdomain.com');

// Database setup
$db = new SQLite3('database.sqlite');
$db->exec('
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT,
        current_line TEXT,
        improved_line TEXT,
        status TEXT DEFAULT "pending",
        stripe_session_id TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
');
?>
