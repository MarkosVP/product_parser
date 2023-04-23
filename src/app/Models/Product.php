<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'code',
        'status',
        'imported_t',
        'url',
        'creator',
        'created_t',
        'last_modified_t',
        'product_name',
        'quantity',
        'brands',
        'categories',
        'labels',
        'cities',
        'purchase_places',
        'stores',
        'ingredients_text',
        'traces',
        'serving_size',
        'serving_quantity',
        'nutriscore_score',
        'nutriscore_grade',
        'main_category',
        'image_url',
    );

    /**
     * O nome da tabela da Model
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * A chave primária da tabela
     *
     * @var array|string
     */
    protected $primaryKey = 'code';

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
    public $timestamps = true;

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
