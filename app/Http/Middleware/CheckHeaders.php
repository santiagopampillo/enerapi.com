<?php

namespace App\Http\Middleware;

use Closure;
use App\UsuarioApi;
use Illuminate\Support\Facades\Hash;

class CheckHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!isset($_SERVER['HTTP_X_SIMA_API_CLIENT'])){
            return response()->json([
                'success' => false,
                'message' => 'Error al autenticarse: falta api clientccc',
            ], 401);
        }

        $existe_email = UsuarioApi::where('email', '=', $_SERVER['HTTP_X_SIMA_API_CLIENT'])->count();
        if($existe_email==0){
            return response()->json([
                'success' => false,
                'message' => 'Error al autenticarse: el email es incorrecto',
            ], 401);
        } 

        if(!isset($_SERVER['HTTP_X_SIMA_API_KEY'])){
            return response()->json([
                'success' => false,
                'message' => 'Error al autenticarse: falta api key',
            ], 401);
        }

        $existe_secret_api = UsuarioApi::where('api_secret', '=', $_SERVER['HTTP_X_SIMA_API_KEY'])->count();
        if($existe_secret_api==0){
            return response()->json([
                'success' => false,
                'message' => 'Error al autenticarse: la api key es incorrecta',
            ], 401);
        } 

        $fecha_hoy = date('Y-m-d');
        $fecha_correcta = UsuarioApi::where('email', '=', $_SERVER['HTTP_X_SIMA_API_CLIENT'])
                                        ->where('api_secret', '=', $_SERVER['HTTP_X_SIMA_API_KEY'])
                                        ->where('fecha_desde', '<=', $fecha_hoy)
                                        ->where('fecha_hasta', '>=', $fecha_hoy)
                                        ->count();
        if($fecha_correcta==0){
            return response()->json([
                'success' => false,
                'message' => 'Error al autenticarse: fuera del rango de fechas',
            ], 401);
        } 


        return $next($request);
    }
}
