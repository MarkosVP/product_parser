<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * O nome da tabela da Model
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * A chave primária da tabela
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * Informo que o campo não é Auto-increment
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * O tipo da data para os campos de data padrão do Eloquent
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * O nome do campo que representa a data de criação para o Eloquant
     */
    const CREATED_AT = 'created_t';

    /**
     * O nome do campo que representa a data da ultima atualização para o Eloquant
     */
    const UPDATED_AT = 'last_modified_t';
}
