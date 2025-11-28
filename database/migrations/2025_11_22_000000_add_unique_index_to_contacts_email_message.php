<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToContactsEmailMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * This adds a unique index to the contacts table on the combination of email and message
     * to prevent duplicate contact submissions at the database level.
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unique(['email', 'message'], 'contacts_email_message_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the unique index on the contacts table.
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique('contacts_email_message_unique');
        });
    }
}

