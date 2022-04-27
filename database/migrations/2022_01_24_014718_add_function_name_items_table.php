<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFunctionNameItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('itemFunctionName')->nullable();
            $table->string('itemOriginalPrice')->nullable();
            $table->integer('isNew')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('itemFunctionName');
            $table->dropColumn('itemOriginalPrice');
            $table->dropColumn('isNew');
        });
    }
}
