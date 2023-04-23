<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function home()
    {
        // Inicializo o array de retorno para a tela
        $viewData = array(
            'products' => array()
        );

        // Busco os dados dos produtos
        $viewData['products'] = Product::all();

        // Retorno na chamada uma VIEW
        return View('home', $viewData);
    }
}
