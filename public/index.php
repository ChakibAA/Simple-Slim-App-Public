<?php
/**
 * Bootstrap file for the Slim application.
 * 
 * This file initializes the Slim application, sets up the necessary dependencies, and defines the routes for handling 
 * authentication (login, logout, register, remember-me).
 */

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\AuthController;
use App\Service\AuthService;

// Create an instance of the Slim application.
$app = AppFactory::create();

// Create instances of the AuthService and AuthController for handling authentication logic.
$authService = new AuthService();
$authController = new AuthController($authService);

/**
 * GET /
 * 
 * Displays the login HTML page.
 * 
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 * 
 * @return Response Renders the login HTML page or a 404 error if the file is not found.
 */
$app->get('/', function (Request $request, Response $response) {
    // Path to the HTML template file.
    $filePath = __DIR__ . '/../templates/login.html';

    // Check if the login HTML file exists and serve it.
    if (file_exists($filePath)) {
        $htmlContent = file_get_contents($filePath);
        $response->getBody()->write($htmlContent);
    } else {
        // Return a 404 error if the file does not exist.
        $response = $response->withStatus(404)->write('404 - File Not Found');
    }

    return $response;
});

/**
 * POST /login
 * 
 * Handles user login by delegating the request to the AuthController's login method.
 * 
 * @see AuthController::login() for details on request and response handling.
 */
$app->post('/login', [$authController, 'login']);

/**
 * POST /logout
 * 
 * Logs out the user by clearing sessions or invalidating tokens.
 * 
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 * @param array $args Route arguments (if any).
 * 
 * @return Response JSON response indicating the logout status.
 */
$app->post('/logout', function (Request $request, Response $response, array $args) {
    // Implement logout logic (e.g., clearing sessions, tokens).
    return $response->withJson(['status' => 'ok', 'message' => 'Logged out']);
});

/**
 * POST /register
 * 
 * Registers a new user in the system.
 * 
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 * @param array $args Route arguments (if any).
 * 
 * @return Response JSON response indicating the registration status.
 */
$app->post('/register', function (Request $request, Response $response, array $args) {
    // Implement user registration logic.
    return $response->withJson(['status' => 'ok', 'message' => 'User registered']);
});

/**
 * POST /remember-me
 * 
 * Extends the user's session using a remember-me token.
 * 
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 * @param array $args Route arguments (if any).
 * 
 * @return Response JSON response indicating the status of the remember-me operation.
 */
$app->post('/remember-me', function (Request $request, Response $response, array $args) {
    // Handle remember-me logic (e.g., validating and extending token).
    return $response->withJson(['status' => 'ok', 'message' => 'Remembered']);
});

// Run the Slim application.
$app->run();
