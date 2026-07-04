<?php
require_once __DIR__ . '/vendor/autoload.php';

$db = \Config\Database::connect();
$user = $db->table('users')->where('email', 'admin@gmail.com')->get()->getRow();

echo "Password hash: " . $user->password_hash . "\n";
echo "Hash length: " . strlen($user->password_hash) . "\n";

$password = '123456';
$verified = password_verify($password, $user->password_hash);
echo "Verify result: " . ($verified ? 'true' : 'false') . "\n";

// Try hashing 123456 to see what we get
$new_hash = password_hash($password, PASSWORD_DEFAULT);
echo "New hash for 123456: " . $new_hash . "\n";

// Also test with the daffa user
$daffa = $db->table('users')->where('email', 'daffa@gmail.com')->get()->getRow();
echo "\nDaffa user:\n";
echo "Password hash: " . $daffa->password_hash . "\n";
$verified_daffa = password_verify('password', $daffa->password_hash);
echo "Verify 'password': " . ($verified_daffa ? 'true' : 'false') . "\n";
?>
