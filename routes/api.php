<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
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
