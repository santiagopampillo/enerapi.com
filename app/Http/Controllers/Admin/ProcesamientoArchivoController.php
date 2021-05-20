<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateProcesamientoArchivoRequest;
use App\Http\Requests\Admin\UpdateProcesamientoArchivoRequest;
use App\Repositories\ProcesamientoArchivoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProcesamientoArchivoController extends AppBaseController
{
    /** @var  ProcesamientoArchivoRepository */
    private $ProcesamientoArchivoRepository;

    public function __construct(ProcesamientoArchivoRepository $ProcesamientoArchivoRepo)
    {
        $this->ProcesamientoArchivoRepository = $ProcesamientoArchivoRepo;
    }

    /**
     * Display a listing of the ProcesamientoArchivo.
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

        $registros = $this->ProcesamientoArchivoRepository->getByFilter($pagination,$filtros);

        if (\Request::input('export')==0){
            return view('admin.procesamientos.index')
                ->with('registros', $registros)->with('filtros', $filtros);
        }    
    }

    /**
     * Show the form for creating a new ProcesamientoArchivo.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created ProcesamientoArchivo in storage.
     *
     * @param CreateProcesamientoArchivoRequest $request
     *
     * @return Response
     */
    public function store(CreateProcesamientoArchivoRequest $request)
    {
        
    }

    /**
     * Display the specified ProcesamientoArchivo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified ProcesamientoArchivo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified ProcesamientoArchivo in storage.
     *
     * @param  int              $id
     * @param UpdateProcesamientoArchivoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcesamientoArchivoRequest $request)
    {
        
    }

    /**
     * Remove the specified ProcesamientoArchivo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
