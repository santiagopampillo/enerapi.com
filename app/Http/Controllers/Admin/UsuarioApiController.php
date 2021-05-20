<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Requests\Admin\CreateUsuarioApiRequest;
use App\Http\Requests\Admin\UpdateUsuarioApiRequest;
use App\Repositories\UsuarioApiRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsuarioApiController extends AppBaseController
{
    /** @var  UsuarioApiRepository */
    private $UsuarioApiRepository;

    public function __construct(UsuarioApiRepository $UsuarioApiRepo)
    {
        $this->UsuarioApiRepository = $UsuarioApiRepo;
    }

    /**
     * Display a listing of the UsuarioApi.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = (\Request::input('export')==0) ? 100 : null;
        
        $filtros = [];
        $filtros["email"] = \Request::input('email');

        $registros = $this->UsuarioApiRepository->getByFilter($pagination,$filtros);

        if (\Request::input('export')==0){
            return view('admin.usuarios_api.index')
                ->with('registros', $registros)->with('filtros', $filtros);
        }    
    }

    /**
     * Show the form for creating a new UsuarioApi.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.usuarios_api.create');
    }

    /**
     * Store a newly created UsuarioApi in storage.
     *
     * @param CreateUsuarioApiRequest $request
     *
     * @return Response
     */
    public function store(CreateUsuarioApiRequest $request)
    {
        $input = $request->all();
        $input["api_secret"]=Hash::make($request->email);

        $fecha_desde = Carbon::createFromFormat('d/m/Y', $input['fecha_desde']);
        $input['fecha_desde'] = $fecha_desde->format('Y-m-d');
        $fecha_hasta = Carbon::createFromFormat('d/m/Y', $input['fecha_hasta']);
        $input['fecha_hasta'] = $fecha_hasta->format('Y-m-d');

        /*
        $fechaAux = $input['fecha_desde'];
        $arrayAux = explode("/",$fechaAux);
        if(count($arrayAux)==3){
            $input['fecha_desde'] = $arrayAux[2]."-".$arrayAux[1]."-".$arrayAux[0];
        }
        $fechaAux = $input['fecha_hasta'];
        $arrayAux = explode("/",$fechaAux);
        if(count($arrayAux)==3){
            $input['fecha_hasta'] = $arrayAux[2]."-".$arrayAux[1]."-".$arrayAux[0];
        }*/

        $UsuarioApi = $this->UsuarioApiRepository->create($input);

        Flash::success('Usuario Api saved successfully.');

        return redirect(route('usuarios_api.index'));
    }

    /**
     * Display the specified UsuarioApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $UsuarioApi = $this->UsuarioApiRepository->findWithoutFail($id);

        if (empty($UsuarioApi)) {
            Flash::error('UsuarioApi not found');

            return redirect(route('usuarios_api.index'));
        }

        return view('admin.usuarios_api.show')->with('UsuarioApi', $UsuarioApi);
    }

    /**
     * Show the form for editing the specified UsuarioApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $registro = $this->UsuarioApiRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('UsuarioApi not found');

            return redirect(route('usuarios_api.index'));
        }

        if ($registro->fecha_desde!=""){
            $registro->fecha_desde = date('d/m/Y',strtotime($registro->fecha_desde));
        }
        if ($registro->fecha_hasta!=""){
            $registro->fecha_hasta = date('d/m/Y',strtotime($registro->fecha_hasta));
        }

        return view('admin.usuarios_api.edit')->with('registro', $registro);
    }

    /**
     * Update the specified UsuarioApi in storage.
     *
     * @param  int              $id
     * @param UpdateUsuarioApiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsuarioApiRequest $request)
    {
        $input = $request->all();

        $UsuarioApi = $this->UsuarioApiRepository->findWithoutFail($id);

        if (empty($UsuarioApi)) {
            Flash::error('UsuarioApi not found');

            return redirect(route('usuarios_api.index'));
        }



        $fecha_desde = Carbon::createFromFormat('d/m/Y', $input['fecha_desde']);
        $input['fecha_desde'] = $fecha_desde->format('Y-m-d');
        $fecha_hasta = Carbon::createFromFormat('d/m/Y', $input['fecha_hasta']);
        $input['fecha_hasta'] = $fecha_hasta->format('Y-m-d');
        

        $UsuarioApi = $this->UsuarioApiRepository->update($input, $id);

        Flash::success('Usuario Api updated successfully.');

        return redirect(route('usuarios_api.index'));
    }

    /**
     * Remove the specified UsuarioApi from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $UsuarioApi = $this->UsuarioApiRepository->findWithoutFail($id);

        if (empty($UsuarioApi)) {
            Flash::error('Usuario Api not found');

            return redirect(route('usuarios_api.index'));
        }

        $this->UsuarioApiRepository->delete($id);

        Flash::success('Usuario Api deleted successfully.');

        return redirect(route('usuarios_api.index'));
    }
}
