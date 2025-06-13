<?php
require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();

$admin_data = [
    'username' => 'admin',
    'email' => 'admin@gmail.com',
    'password' => 'admin', // Change this to a secure password`
    'role' => 'admin'
];

if ($auth->register(
    $admin_data['username'],
    $admin_data['email'],
    $admin_data['password'],
    $admin_data['role']
)) {
    echo "Admin registered successfully!";
} else {
    echo "Failed to register admin. Email might already exist.";
}