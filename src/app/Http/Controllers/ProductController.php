<?php

namespace App\Http\Controllers;

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

        // Retorno OK para a requisição
        return RequestUtils::retornaSucesso('OK');
    }
}
