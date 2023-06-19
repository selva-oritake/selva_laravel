<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('product_category_id');
            $table->integer('product_subcategory_id');
            $table->string('name');
            $table->string('image_1')->nullable()->default(null);
            $table->string('image_2')->nullable()->default(null);
            $table->string('image_3')->nullable()->default(null);
            $table->string('image_4')->nullable()->default(null);
            $table->text('product_content');
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes('deleted_at')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
