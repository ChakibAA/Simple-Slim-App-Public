<?php

/**
 * Database connection setup using Eloquent's Capsule Manager.
 * 
 * This script initializes the Capsule instance for connecting to a SQLite database.
 * It sets the connection details and configures Eloquent ORM for use throughout the application.
 */

use Illuminate\Database\Capsule\Manager as Capsule;

// Create a new instance of the Capsule manager for database operations.
$capsule = new Capsule;

// Add a connection to the SQLite database.
$capsule->addConnection([
    'driver' => 'sqlite', // Database driver to be used.
    'database' => __DIR__ . '/../database/database.sqlite', // Path to the SQLite database file.
    'prefix' => '', // No prefix for table names.
]);

// Set the Capsule instance as global, allowing it to be used anywhere in the application.
$capsule->setAsGlobal();

// Boot Eloquent, enabling the ORM features for the application.
$capsule->bootEloquent();
