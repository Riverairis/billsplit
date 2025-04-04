<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('invitations', function (Blueprint $table) {
        // If you have a 'code' column that should be 'token'
        $table->renameColumn('code', 'token');
        
        // Or if you need to add the token column
        $table->string('token')->unique()->after('nickname');
    });
}
};
