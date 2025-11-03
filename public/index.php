<?php
// Front controller for the Charity Portal app

declare(strict_types=1);

// Start session early
session_start();

// Project root
define('BASE_PATH', dirname(__DIR__));

// Autoloader (PSR-4 like for App namespace)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load config
require BASE_PATH . '/config/config.php';

// Helper functions
require BASE_PATH . '/app/helpers.php';

use App\Core\Router;

// Initialize Router
$router = new Router();

// Routes
$router->get('/', 'HomeController@index');

// Authentication
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Institutions CRUD
$router->get('/institutions', 'InstitutionController@index');
$router->get('/institutions/create', 'InstitutionController@create');
$router->post('/institutions/store', 'InstitutionController@store');
$router->get('/institutions/edit', 'InstitutionController@edit'); // ?id=
$router->post('/institutions/update', 'InstitutionController@update');
$router->post('/institutions/delete', 'InstitutionController@delete');

// Users (donors/volunteers) CRUD
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/edit', 'UserController@edit');
$router->post('/users/update', 'UserController@update');
$router->post('/users/delete', 'UserController@delete');

// Donations CRUD
$router->get('/donations', 'DonationController@index');
$router->get('/donations/create', 'DonationController@create');
$router->post('/donations/store', 'DonationController@store');
$router->post('/donations/delete', 'DonationController@delete');

// Events CRUD
$router->get('/events', 'EventController@index');
$router->get('/events/create', 'EventController@create');
$router->post('/events/store', 'EventController@store');
$router->post('/events/delete', 'EventController@delete');

// Reports
$router->get('/reports/donations', 'ReportController@donations');
$router->get('/reports/rankings', 'ReportController@rankings');

// Gamification & Transparency
$router->get('/leaderboard', 'GamificationController@leaderboard');
$router->get('/transparency', 'GamificationController@transparencyWall');

// Dispatch request
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
