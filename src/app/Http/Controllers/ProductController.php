<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Product;
use App\Utils\RequestUtils;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Lista todos os Produtos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Busco todos os produtos do banco
        $products = Product::all();

        // Retorno os dados dos produtos
        return RequestUtils::retornaSucesso($products);
    }

    /**
     * Busca um produto em específico
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        // Busco o produto solicitado
        $produto = Product::find($code);

        // Retorno os dados em um array
        return RequestUtils::retornaSucesso(
            $produto
        );
    }

    /**
     * Atualiza um produto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        // Busco o produto do banco
        $product = Product::find($code);

        // Recupero o status
        $status = $request->input('status');

        // Checo se foi informado status para atualização
        if (!empty($status)) {
            // Valido se o status informado é diferente dos possíveis
            if (!is_string($status) ||
                ($status != Status::DRAFT && $status != Status::PUBLISHED && $status != Status::TRASH)
            ) {
                return RequestUtils::retornaErroTratado(
                    'O status informado não é válido'
                );
            }

            // Atualizo o campo
            $product->status = $status;
        }

        // Recupero o input
        $prodCreation = $request->input('created_t');

        // Checo se o campo foi informado
        if (!empty($prodCreation)) {
            // Valido o campo
            if (!is_numeric($prodCreation)) {
                return RequestUtils::retornaErroTratado(
                    'O Timestamp da Criação do Produto informado não é válido'
                );
            }

            // Atualizo o campo
            $product->created_t = (int)$prodCreation;
        }

        // Recupero o input
        $prodQtde = $request->input('quantity');

        // Checo se o campo foi informado
        if (!empty($prodQtde)) {
            // Valido o campo
            if (!is_numeric($prodQtde)) {
                return RequestUtils::retornaErroTratado(
                    'A Quantidade do Produto informado não é válida'
                );
            }

            // Atualizo o campo
            $product->quantity = (int)$prodQtde;
        }

        // Atualizo os campos
        $product->url              = $request->input('url') ?? $product->url;
        $product->creator          = $request->input('creator') ?? $product->creator;
        $product->product_name     = $request->input('product_name') ?? $product->product_name;
        $product->brands           = $request->input('brands') ?? $product->brands;
        $product->categories       = $request->input('categories') ?? $product->categories;
        $product->labels           = $request->input('labels') ?? $product->labels;
        $product->cities           = $request->input('cities') ?? $product->cities;
        $product->purchase_places  = $request->input('purchase_places') ?? $product->purchase_places;
        $product->stores           = $request->input('stores') ?? $product->stores;
        $product->ingredients_text = $request->input('ingredients_text') ?? $product->ingredients_text;
        $product->traces           = $request->input('traces') ?? $product->traces;
        $product->serving_size     = $request->input('serving_size') ?? $product->serving_size;
        $product->nutriscore_grade = $request->input('nutriscore_grade') ?? $product->nutriscore_grade;
        $product->main_category    = $request->input('main_category') ?? $product->main_category;
        $product->image_url        = $request->input('image_url') ?? $product->image_url;

        // Recupero o input
        $prodServingQtde = $request->input('serving_quantity');

        // Checo se o campo foi informado
        if (!empty($prodServingQtde)) {
            // Valido o campo
            if (!is_numeric($prodServingQtde)) {
                return RequestUtils::retornaErroTratado(
                    'A Quantidade da Porção do Produto informado não é válida'
                );
            }

            // Atualizo o campo
            $product->serving_quantity = (float)$prodServingQtde;
        }

        // Recupero o input
        $prodNutriScore = $request->input('nutriscore_score');

        // Checo se o campo foi informado
        if (!empty($prodNutriScore)) {
            // Valido o campo
            if (!is_numeric($prodNutriScore)) {
                return RequestUtils::retornaErroTratado(
                    'O Valor Nutricional do Produto informado não é válido'
                );
            }

            // Atualizo o campo
            $product->nutriscore_score = (int)$prodNutriScore;
        }

        // Atualizo a data da ultima modificação automáticamente
        $product->last_modified_t = date('U');

        // Salvo as alterações
        $product->save();

        // Retorno OK para a requisição
        return RequestUtils::retornaSucesso('OK');
    }

    /**
     * Deleta um produto
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        // Busco o produto do banco
        $product = Product::find($code);

        // Atualizo o status do produto para 'trash'
        $product->status = Status::TRASH;
        $product->save();

        // Retorno OK para a requisição
        return RequestUtils::retornaSucesso('OK');
    }
}
