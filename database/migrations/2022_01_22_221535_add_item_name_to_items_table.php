<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemNameToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('itemName')->nullable();
            $table->string('itemUrl')->nullable();
            $table->integer('itemPrice')->nullable();
            $table->boolean('inOffer')->nullable();
            $table->integer('subCategoryId');
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
            $table->dropColumn('itemName');
            $table->dropColumn('itemUrl');
            $table->dropColumn('itemPrice');
            $table->dropColumn('inOffer');
            $table->dropColumn('subCategoryId');
        });
    }
}
