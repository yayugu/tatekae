<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE users(
                `id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                `email` VARCHAR(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL UNIQUE,
                `password` VARCHAR(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
                `remember_token` VARCHAR(100) CHARACTER SET ascii COLLATE ascii_general_ci,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL
            );
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
