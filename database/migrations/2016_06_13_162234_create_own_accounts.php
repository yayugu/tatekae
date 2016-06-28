<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE own_accounts(
                `account_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                `owner_user_id` BIGINT UNSIGNED NOT NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL
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
        Schema::drop('own_accounts');
    }
}
