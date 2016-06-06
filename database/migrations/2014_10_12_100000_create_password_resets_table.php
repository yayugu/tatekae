<?php

use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE password_resets(
                `email` VARCHAR(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL PRIMARY KEY,
                `token` VARCHAR(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
                `created_at` DATETIME NOT NULL
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
        Schema::drop('password_resets');
    }
}
