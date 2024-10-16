<?php

namespace App\Service;

use Illuminate\Database\Capsule\Manager as DB;

class AuthService
{
    /**
     * Logs in a user using the provided email and password.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @param bool $rememberMe If true, a remember-me token is generated to maintain the session.
     * 
     * @return array An associative array containing:
     *  - 'status': 'ok' if login is successful, 'error' if login fails.
     *  - 'message': A message explaining the login result, such as 'Invalid credentials' on failure.
     *  - 'username': (only on success) The username of the authenticated user.
     */
    public function login(string $email, string $password, bool $rememberMe)
    {
        // Retrieve the user from the database based on the provided email.
        $user = DB::table('users')->where('email', $email)->first();

        // Check if the user exists and the provided password is correct.
        if (!$user || !password_verify($password, $user->password)) {
            return ['status' => 'error', 'message' => 'Invalid credentials'];
        }

        // If the rememberMe flag is set, generate and store a remember-me token for the user.
        if ($rememberMe) {
            $token = bin2hex(random_bytes(50));
            DB::table('users')->where('email', $email)->update(['remember_token' => $token]);
        }

        // Return a success status along with the username.
        return ['status' => 'ok', 'username' => $user->username];
    }
}
