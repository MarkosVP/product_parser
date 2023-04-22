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
    private $_tableName = 'prodcron_errors';

    /**
     * Array contendo as tabelas utilizadas na FK
     *
     * @var array
     */
    private $_foreignTables = array(
        'prodcron'
    );

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
                $table->bigInteger('cron_id')->comment('ID da CRON executada');
                $table->bigInteger('registry_id')->comment('ID de controle dos erros por CRON');
                $table->string('error')->comment('Informação do erro');
                $table->integer('error_data')->nullable()->comment('Dados do registro que gerou erro');

                // Defino a PK da tabela
                $table->primary(array('cron_id', 'registry_id'));

                // Gero FK com a tabela de CRON
                $table->foreign('cron_id')->references('id')->on($this->_foreignTables[0]);

                // Comento na tabela
                $table->comment('Tabela contendo os registros de erro separados por execução de CRON e ID interno para cada registro');
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
