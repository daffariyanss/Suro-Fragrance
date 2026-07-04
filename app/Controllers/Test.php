<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function password()
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('email', 'admin@gmail.com')->get()->getRow();

        echo "<pre>";
        echo "Password hash: " . $user->password_hash . "\n";
        echo "Hash length: " . strlen($user->password_hash) . "\n";

        $password = '123456';
        $verified = password_verify($password, $user->password_hash);
        echo "Verify '123456': " . ($verified ? 'TRUE' : 'FALSE') . "\n";

        // Try hashing 123456 to see what we get
        $new_hash = password_hash($password, PASSWORD_DEFAULT);
        echo "New hash for 123456: " . $new_hash . "\n";

        // Also test with the daffa user
        $daffa = $db->table('users')->where('email', 'daffa@gmail.com')->get()->getRow();
        echo "\nDaffa user:\n";
        echo "Password hash: " . $daffa->password_hash . "\n";
        $verified_daffa = password_verify('password', $daffa->password_hash);
        echo "Verify 'password': " . ($verified_daffa ? 'TRUE' : 'FALSE') . "\n";
        echo "</pre>";
    }

    public function updatePassword()
    {
        $db = \Config\Database::connect();
        
        // Create new password hash
        $password = '123456';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Update admin user
        $db->table('users')->where('email', 'admin@gmail.com')->update([
            'password_hash' => $hash
        ]);
        
        echo "<pre>";
        echo "Password updated for admin@gmail.com\n";
        echo "New hash: " . $hash . "\n";
        
        // Verify
        $user = $db->table('users')->where('email', 'admin@gmail.com')->get()->getRow();
        $verified = password_verify($password, $user->password_hash);
        echo "Verify result: " . ($verified ? 'TRUE' : 'FALSE') . "\n";
        echo "</pre>";
        
        echo '<a href="/login/admin">Go to Login Admin</a>';
    }
}
