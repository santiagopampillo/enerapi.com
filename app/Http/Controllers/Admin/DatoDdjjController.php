<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateDatoDDJJRequest;
use App\Http\Requests\Admin\UpdateDatoDDJJRequest;
use App\Repositories\DatoDDJJRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Empresa;
use App\DatoDDJJ;

class DatoDDJJController extends AppBaseController
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
    public function index(Request $request)
    {
        $pagination = (\Request::input('export')==0) ? 100 : null;

        $filtros = [];
        $filtros["cuenca"] = \Request::input('cuenca');
        $filtros["empresa"] = \Request::input('empresa');
        $filtros["mes"] = \Request::input('mes');
        $filtros["anio"] = \Request::input('anio');
        $filtros["sigla"] = \Request::input('sigla');

        $empresas = Empresa::all();

        if($filtros["cuenca"] != "" || 
            $filtros["empresa"] != "" ||
            $filtros["mes"] != "" ||
            $filtros["anio"] != "" || 
            $filtros["sigla"] != ""){

            $registros = $this->DatoDDJJRepository->getByFilter($pagination,$filtros);
        } else {
            $registros=null;
        }

//dd($registros[11]);

        if (\Request::input('export')==0){
            return view('admin.datosDdjj.index')
                ->with('registros', $registros)->with('filtros', $filtros)->with('empresas', $empresas);
        }    
    }

    /**
     * Show the form for creating a new DatoDDJJ.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created DatoDDJJ in storage.
     *
     * @param CreateDatoDDJJRequest $request
     *
     * @return Response
     */
    public function store(CreateDatoDDJJRequest $request)
    {
        
    }

    /**
     * Display the specified DatoDDJJ.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
    }

    public function view($id)
    {
        $registro = $this->DatoDDJJRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('DatoDDJJ not found');

            return redirect(route('datosDdjj.index'));
        }

        $datos = array('mes', 'anio', 'cuenca', 'provincia', 'area', 'yacimiento', 'id_pozo', 'sigla', 'form_prod', 'cod_propio', 'nom_propio', 'prod_men_pet', 'prod_men_gas', 'prod_men_agua', 'prod_acum_pet', 'prod_acum_gas', 'prod_acum_agua', 'iny_agua', 'iny_gas', 'iny_cO2', 'iny_otros', 'rgp', 'porc_de_agua', 'tef', 'vida_util', 'sist_extrac', 'est_pozo', 'tipo_pozo', 'clasificacion', 'sub_clasificacion', 'tipo_de_recurso', 'sub_tipo_de_recurso', 'observaciones', 'latitud', 'longitud', 'cota', 'profundidad');

        return view('admin.datosDdjj.view')->with(['registro'=> $registro, 'datos' => $datos]);
    }

    /**
     * Show the form for editing the specified DatoDDJJ.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified DatoDDJJ in storage.
     *
     * @param  int              $id
     * @param UpdateDatoDDJJRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDatoDDJJRequest $request)
    {
        
    }

    /**
     * Remove the specified DatoDDJJ from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
