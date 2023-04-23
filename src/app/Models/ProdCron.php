<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdCron extends Model
{
    use HasFactory;

    /**
     * O nome da tabela da Model
     *
     * @var string
     */
    protected $table = 'prodcron';

    /**
     * A chave primária da tabela
     *
     * @var array|string
     */
    protected $primaryKey = 'id';

    /**
     * Informo se o campo é Auto-increment
     *
     * @var boolean
     */
    public $incrementing = true;

    /**
     * Informo se a tabela contém campos de _Created_ ou _Updated_
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * O tipo da data para os campos de data padrão do Eloquent
     *
     * @var string
     */
    protected $dateFormat = '';
}
