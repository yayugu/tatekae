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
                `social_provider` VARCHAR(50) NOT NULL,
                `social_id` VARCHAR(255) NOT NULL,
                `screen_name` VARCHAR(255) NOT NULL UNIQUE,
                `icon` VARCHAR(1024) NOT NULL,
                `account_id` BIGINT UNSIGNED NOT NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL,
                UNIQUE KEY (`social_id`, `social_provider`)
            ) ENGINE=InnoDB ROW_FORMAT=DYNAMIC CHARACTER SET ascii COLLATE ascii_general_ci;
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
