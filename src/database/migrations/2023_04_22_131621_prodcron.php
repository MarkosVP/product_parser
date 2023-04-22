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
    private $_tableName = 'prodcron';

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
                $table->id()->comment('O ID de execução da CRON');
                $table->timestamp('executed_in')->default(date('Y-m-d H:i:s'))->comment('O Timestamp de execução inicial da CRON');
                $table->integer('imported')->default(0)->comment('Qunatidade de registros importados');
                $table->integer('imported_errors')->default(0)->comment('Quantidade de erros durante a importação');

                // Comento a descrição da tabela
                $table->comment('Tabela contendo os dados de execução da CRON');
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
