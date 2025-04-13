<?php

ini_set('allow_url_fopen', 1);
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($request) {
    // Guest (unauthenticated) routes
    case '/login':
    case '/login.php':
    case '/':
        require 'login.php';
        break;

    case '/register':
    case '/register.php':
        require 'register.php';
        break;

    // Admin routes
    case '/admin_page':
    case '/admin_page.php':
        require 'admin_page.php';
        break;

    case '/admin_products':
    case '/admin_products.php':
        require 'admin_products.php';
        break;

    case '/admin_orders':
    case '/admin_orders.php':
        require 'admin_orders.php';
        break;

    case '/admin_users':
    case '/admin_users.php':
        require 'admin_users.php';
        break;

    case '/admin_contacts':
    case '/admin_contacts.php':
        require 'admin_contacts.php';
        break;

    // Authenticated user routes
    case '/home':
    case '/home.php':
        require 'home.php';
        break;

    case '/about':
    case '/about.php':
        require 'about.php';
        break;

    case '/contact':
    case '/contact.php':
        require 'contact.php';
        break;

    case '/orders':
    case '/orders.php':
        require 'orders.php';
        break;

    case '/search_page':
    case '/search_page.php':
        require 'search_page.php';
        break;

    case '/shop':
    case '/shop.php':
        require 'shop.php';
        break;

    case '/cart':
    case '/cart.php':
        require 'cart.php';
        break;

    case '/checkout':
    case '/checkout.php':
        require 'checkout.php';
        break;

 
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
