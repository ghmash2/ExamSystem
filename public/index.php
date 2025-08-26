<?php
session_start();
require_once '../app/database.php';
// var_dump($_SERVER['REQUEST_URI'], $_GET);
// die();
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']); 
$route = str_replace($scriptDir, '', $uri); // Remove the "public" base dir from the URI if needed
$route = parse_url($route, PHP_URL_PATH); // Remove query string if any
$route = trim($route, '/');

$routes = [
    '' => '/view/home.php',
    'home' => '/view/home.php',
    'login' => '/view/login.php',
    'register' => '/view/register.php',
    'showResultOnSubmit' => '/view/showResultOnSubmit.php',
    'exam' => '/view/exam.php',
    // 'forgotPassword' => '/view/forgotPassword.php',
    // 'termsPrivacy' => '/view/termsPrivacy.php',
    // 'profile' => '/view/profile.php',
];

if (isset($routes[$route])) {
    $routeFound = true;
    include __DIR__ . $routes[$route];  // Use absolute path to ensure correct inclusion
    exit;
} else {
    http_response_code(404);
    include __DIR__ . '/view/404.php';
    exit;
}
// require_once '../public/view/home.php';
?>