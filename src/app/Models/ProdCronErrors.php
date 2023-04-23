<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdCronErrors extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'cron_id',
        'registry_id',
        'error',
        'error_data',
    );

    /**
     * O nome da tabela da Model
     *
     * @var string
     */
    protected $table = 'prodcron_errors';

    /**
     * A chave primária da tabela
     *
     * @var array|string
     */
    protected $primaryKey = '';

    /**
     * Informo se o campo é Auto-increment
     *
     * @var boolean
     */
    public $incrementing = false;

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
