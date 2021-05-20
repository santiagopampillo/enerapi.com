<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\DatoDDJJRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DatoDdjjController extends Controller
{
    /** @var  DatoDDJJRepository */
    private $DatoDDJJRepository;

    public function __construct(DatoDDJJRepository $DatoDDJJRepo)
    {
        $this->DatoDDJJRepository = $DatoDDJJRepo;
    }

    /**
     * Display a listing of the DatoDDJJ.
     *
     * @param Request $request
     * @return Response
     */
    public function filtrar(Request $request)
    {
        /*
        Parametros para buscar
        codigo
        mes
        anio
        cuenca
        yacimiento
        id_pozo

        http://localhost:8000/api/ddjj?codigo=PAE&mes=8&anio=2019&cuenca=&yacimiento=&id_pozo=146750
        */

        if(isset($request["codigo"])) $codigo = $request["codigo"]; else $codigo=null;
        if(isset($request["mes"])) $mes = $request["mes"]; else $mes=null;
        if(isset($request["anio"])) $anio = $request["anio"]; else $anio=null;
        if(isset($request["cuenca"])) $cuenca = $request["cuenca"]; else $cuenca=null;
        if(isset($request["yacimiento"])) $yacimiento = $request["yacimiento"]; else $yacimiento=null;
        if(isset($request["id_pozo"])) $id_pozo = $request["id_pozo"]; else $id_pozo=null;

        if($codigo!=null || $mes!=null || $anio!=null || $cuenca!=null || $yacimiento!=null || $id_pozo!=null){

            $resultado = $this->DatoDDJJRepository->filtrar($request);

            return response()->json([
                'status' => $resultado
            ], 200);


        } else {
            return response()->json([
                'success' => false,
                'message' => 'Debe enviar al menos un parametro de busqueda',
            ], 401);
        }


    }
}
