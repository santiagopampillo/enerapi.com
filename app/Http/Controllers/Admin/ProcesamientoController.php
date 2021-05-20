<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ProcesamientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProcesamientoController extends AppBaseController
{
    /** @var  ProcesamientoRepository */
    private $ProcesamientoRepository;

    public function __construct(ProcesamientoRepository $ProcesamientoRepo)
    {
        $this->ProcesamientoRepository = $ProcesamientoRepo;
    }

    /**
     * Display a listing of the Procesamiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = (\Request::input('export')==0) ? 100 : null;

        $filtros = [];
        $filtros["anio"] = \Request::input('anio');
        $filtros["mes"] = \Request::input('mes');
        $filtros["codigo"] = \Request::input('codigo');

        $registros = $this->ProcesamientoRepository->getByFilter($pagination,$filtros);

        if (\Request::input('export')==0){
            return view('admin.proceso_procesar_archivos.index')
                ->with('registros', $registros)->with('filtros', $filtros);
        }    
    }

    /**
     * Show the form for creating a new Procesamiento.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created Procesamiento in storage.
     *
     * @param CreateProcesamientoRequest $request
     *
     * @return Response
     */
    public function store()
    {
        
    }

    /**
     * Display the specified Procesamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified Procesamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified Procesamiento in storage.
     *
     * @param  int              $id
     * @param UpdateProcesamientoRequest $request
     *
     * @return Response
     */
    public function update()
    {
        
    }

    /**
     * Remove the specified Procesamiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
