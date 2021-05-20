<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateEmpresaRequest;
use App\Http\Requests\Admin\UpdateEmpresaRequest;
use App\Repositories\EmpresaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EmpresaController extends AppBaseController
{
    /** @var  EmpresaRepository */
    private $EmpresaRepository;

    public function __construct(EmpresaRepository $EmpresaRepo)
    {
        $this->EmpresaRepository = $EmpresaRepo;
    }

    /**
     * Display a listing of the Empresa.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = (\Request::input('export')==0) ? 100 : null;
        
        $filtros = [];
        $filtros["nombre"] = \Request::input('nombre');

        $registros = $this->EmpresaRepository->getByFilter($pagination,$filtros);

        if (\Request::input('export')==0){
            return view('admin.empresas.index')
                ->with('registros', $registros)->with('filtros', $filtros);
        }    
    }

    /**
     * Show the form for creating a new Empresa.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.Empresas.create');
    }

    /**
     * Store a newly created Empresa in storage.
     *
     * @param CreateEmpresaRequest $request
     *
     * @return Response
     */
    public function store(CreateEmpresaRequest $request)
    {
        $input = $request->all();
        $input["estado"]=1;

        $Empresa = $this->EmpresaRepository->create($input);

        Flash::success('Empresa saved successfully.');

        return redirect(route('empresas.index'));
    }

    /**
     * Display the specified Empresa.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $Empresa = $this->EmpresaRepository->findWithoutFail($id);

        if (empty($Empresa)) {
            Flash::error('Empresa not found');

            return redirect(route('empresas.index'));
        }

        return view('admin.Empresas.show')->with('Empresa', $inmobiliaria);
    }

    /**
     * Show the form for editing the specified Empresa.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $registro = $this->EmpresaRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('Empresa not found');

            return redirect(route('empresas.index'));
        }

        return view('admin.Empresas.edit')->with('registro', $registro);
    }

    /**
     * Update the specified Empresa in storage.
     *
     * @param  int              $id
     * @param UpdateEmpresaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmpresaRequest $request)
    {
        $Empresa = $this->EmpresaRepository->findWithoutFail($id);

        if (empty($Empresa)) {
            Flash::error('Empresa not found');

            return redirect(route('empresas.index'));
        }

        $Empresa = $this->EmpresaRepository->update($request->all(), $id);

        Flash::success('Empresa updated successfully.');

        return redirect(route('empresas.index'));
    }

    /**
     * Remove the specified Empresa from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $Empresa = $this->EmpresaRepository->findWithoutFail($id);

        if (empty($Empresa)) {
            Flash::error('Empresa not found');

            return redirect(route('empresas.index'));
        }

        $this->EmpresaRepository->delete($id);

        Flash::success('Empresa deleted successfully.');

        return redirect(route('empresas.index'));
    }
}
