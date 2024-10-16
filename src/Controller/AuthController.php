<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\AuthService;

class AuthController
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService An instance of the AuthService used for handling authentication logic.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handles the login request.
     *
     * @param Request $request The HTTP request object containing login details.
     * @param Response $response The HTTP response object used to send data back to the client.
     * 
     * @return Response The HTTP response object with JSON-encoded status and message.
     * 
     * The method extracts the user's email, password, and optional "Remember Me" flag from the request body.
     * It performs validation to ensure the email and password are provided, and then calls the AuthService's login method.
     * The response status will be:
     * - 200 with a success message if login is successful.
     * - 400 if email or password is missing.
     * - 401 if login fails due to incorrect credentials.
     */
    public function login(Request $request, Response $response): Response
    {
        // Decode the JSON body from the request into an associative array.
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = $_POST['rememberMe'] ?? false;

        // Validate that both email and password are provided.
        if (empty($email) || empty($password)) {
            $responseData = [
                'status' => 'error',
                'message' => "Email and password are required",
            ];
            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Call the AuthService to attempt logging in with the provided credentials.
        $result = $this->authService->login($email, $password, $rememberMe);

        // If login is successful, return a success message.
        if ($result['status'] === 'ok') {
            $responseData = [
                'status' => 'ok',
                'message' => "Hello User, you are logged in as $email.",
            ];
            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }

        // If login fails, return an error message with a 401 status.
        $responseData = [
            'status' => 'error',
            'message' => $result['message']
        ];
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    }
}
