<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE user_relationships(
                `user_one_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                `user_two_id` BIGINT UNSIGNED NOT NULL,
                `created_by` BIGINT UNSIGNED NOT NULL,
                `state` INT UNSIGNED NOT NULL,
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
        Schema::drop('user_relationships');
    }
}
