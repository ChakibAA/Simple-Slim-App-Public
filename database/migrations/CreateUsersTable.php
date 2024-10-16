<?php

/**
 * Migration script to create the 'users' table in the database.
 * 
 * This script uses the Eloquent Schema Builder to define the structure of the 'users' table, 
 * which will store user-related information for authentication purposes.
 */

use Illuminate\Database\Capsule\Manager as Capsule;

// Create the 'users' table with specified columns and their attributes.
Capsule::schema()->create('users', function ($table) {
    // Auto-incrementing primary key for the table.
    $table->increments('id');

    // Unique username for each user, which must be a string.
    $table->string('username')->unique();

    // Unique email address for each user, which must be a string.
    $table->string('email')->unique();

    // Password for the user (will be stored as a hashed string).
    $table->string('password');

    // Nullable remember_token for maintaining user sessions (if implemented).
    $table->string('remember_token')->nullable();

    // Timestamps for tracking creation and update times.
    $table->timestamps();
});
