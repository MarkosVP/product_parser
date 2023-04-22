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
                $table->integer('code')->primary();
                $table->string('status');
                $table->dateTime('imported_t')->default(date('Y-m-d H:i:s'));
                $table->string('url')->nullable();
                $table->string('creator');
                $table->integer('created_t')->default(strtotime(date('Y-m-d H:i:s')));
                $table->integer('last_modified_t')->default(strtotime(date('Y-m-d H:i:s')));
                $table->string('product_name');
                $table->string('quantity');
                $table->string('brands');
                $table->string('categories')->nullable();
                $table->string('labels')->nullable();
                $table->string('cities')->nullable();
                $table->string('purchase_places')->nullable();
                $table->string('stores')->nullable();
                $table->string('ingredients_text')->nullable();
                $table->string('traces')->nullable();
                $table->string('serving_size')->nullable();
                $table->float('serving_quantity')->nullable();
                $table->integer('nutriscore_score')->nullable();
                $table->string('nutriscore_grade')->nullable();
                $table->string('main_category')->nullable();
                $table->string('image_url')->nullable();

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
