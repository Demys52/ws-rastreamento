<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::any('/', function (Request $request) {
    try {
        //* LOG FATURAMENTO
        $logFaturamento = Log::channel("sucesso");
        $logFaturamento->warning('REQUISIÇÃO DO RASTREADOR', [
            'Request' => [
                $request->all()
            ],
        ]);
        return response()->json(['pagina correta enviando mensagem para o slack'], 200);
    } catch (\Exception $e) {
        response()->json([$e->getMessage()], 400);
    }
});
Route::fallback(function (Request $request){
    try {
        //* LOG FATURAMENTO
        $logFaturamento = Log::channel("error-404");
        $logFaturamento->warning('REQUISIÇÃO DO RASTREADOR', [
            'Request' => [
                $request->all()
            ],
        ]);
        return response()->json(['pagina não encontrada, enviando mensagem para o slack'], 400);
    } catch (\Exception $e) {
        response()->json([$e->getMessage()], 400);
    }
});
