<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * O nome da tabela no banco
     *
     * @var string
     */
    private $_tableName = 'products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crio a tabela
        Schema::create(
            $this->_tableName,
            function (Blueprint $table) {
                $table->bigInteger('code')->primary();
                $table->string('status');
                $table->dateTime('imported_t')->default(date('Y-m-d H:i:s'));
                $table->text('url')->nullable();
                $table->text('creator');
                $table->integer('created_t')->default(strtotime(date('Y-m-d H:i:s')));
                $table->integer('last_modified_t')->default(strtotime(date('Y-m-d H:i:s')));
                $table->text('product_name');
                $table->integer('quantity')->default(1);
                $table->text('brands')->nullable();
                $table->text('categories')->nullable();
                $table->text('labels')->nullable();
                $table->text('cities')->nullable();
                $table->text('purchase_places')->nullable();
                $table->text('stores')->nullable();
                $table->text('ingredients_text')->nullable();
                $table->text('traces')->nullable();
                $table->text('serving_size')->nullable();
                $table->float('serving_quantity')->nullable();
                $table->integer('nutriscore_score')->nullable();
                $table->text('nutriscore_grade')->nullable();
                $table->text('main_category')->nullable();
                $table->text('image_url')->nullable();

                // Comento na tabela
                $table->comment('Tabela contendo os produtos do projeto');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dropa a tabela se existir no banco
        Schema::dropIfExists($this->_tableName);
    }
};
