<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateParametroRequest;
use App\Http\Requests\Admin\UpdateParametroRequest;
use App\Repositories\ParametroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Provincia;
use Excel;

class ParametroController extends AppBaseController
{
    /** @var  ParametroRepository */
    private $parametroRepository;

    public function __construct(ParametroRepository $parametroRepo)
    {
        $this->parametroRepository = $parametroRepo;
    }

    /**
     * Display a listing of the Parametro.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = 100;
        
        $filtros = [];
        $with = [];

        $registros = $this->parametroRepository->getByFilter($pagination,$filtros,$with);
        return view('admin.parametros.edit')->with('registros', $registros);
    }

    /**
     * Show the form for creating a new Parametro.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.parametros.create');
    }

    /**
     * Store a newly created Parametro in storage.
     *
     * @param CreateParametroRequest $request
     *
     * @return Response
     */
    public function store(CreateParametroRequest $request)
    {
        $input = $request->all();

        $parametro = $this->parametroRepository->create($input);

        Flash::success('Parametro saved successfully.');

        return redirect(route('parametros.index'));
    }

    /**
     * Display the specified Parametro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parametro = $this->parametroRepository->findWithoutFail($id);

        if (empty($parametro)) {
            Flash::error('Parametro not found');

            return redirect(route('parametros.index'));
        }

        return view('admin.parametros.show')->with('parametro', $parametro);
    }

    /**
     * Show the form for editing the specified Parametro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $registro = $this->parametroRepository->findWithoutFail($id);

        $valores = json_decode($registro->valores);

        $provincias = null;
        if ($id == 3){
            $provincias = Provincia::get();
        }

        if (empty($registro)) {
            Flash::error('Registro no encontrado');

            return redirect(route('parametros.edit',1));
        }

        return view('admin.parametros.edit')->with('registro', $registro)->with('valores',$valores)->with('provincias',$provincias);
    }

    /**
     * Update the specified Parametro in storage.
     *
     * @param  int              $id
     * @param UpdateParametroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParametroRequest $request)
    {
        $registro = $this->parametroRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('Registro no encontrado');

            return redirect(route('parametros.edit',1));
        }

        $input = $request->all();

        switch ($id) {
            case 1:
                $input["valores"] = json_encode([$input["edad_minima"],$input["edad_maxima"]]);
                break;
            case 2:
                $input["valores"] = json_encode($input["codigos"]);
                break;
            case 3:
                $input["valores"] = json_encode($input["provincias"]);
                break;
            case 4:
                $input["valores"] = json_encode($input["codigos"]);
                break;
            case 5:
                $input["valores"] = json_encode(['meses_validar' => $input["meses_validar"],'situacion_minima' => $input["situacion_minima"]]);
                break;
            case 6:
                $codigos = [];
                for ($i=0;$i<count($input["codigos"]);$i++){
                    array_push($codigos,['codigo' => $input["codigos"][$i],'meses' => $input["meses"][$i]]);
                }
                $input["valores"] = json_encode($codigos);
                break;
            case 7:
                $input["valores"] = json_encode($input["categorias_monotributo"]);
                break;
            case 8:
                $input["valores"] = json_encode(['meses_validar' => $input["meses_validar"],'situaciones_bcra' => $input["situaciones_bcra"],'porc_aceptacion' => $input["porc_aceptacion"]]);
                break;
            case 9:
                $codigos = [];
                for ($i=0;$i<count($input["codigos"]);$i++){
                    array_push($codigos,['codigo' => $input["codigos"][$i],'dni' => $input["dni"][$i],'recibo_hab' => $input["recibo_hab"][$i],'fac_servicios' => $input["fac_servicios"][$i],'mov_bancarios' => $input["mov_bancarios"][$i],'comp_cbu' => $input["comp_cbu"][$i]]);
                }
                $input["valores"] = json_encode($codigos);
                break;
        }
        

        $registro = $this->parametroRepository->update($input, $id);

        Flash::success('Registro actualizado.');

        return redirect(route('parametros.edit',$id));
    }

    /**
     * Remove the specified Parametro from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parametro = $this->parametroRepository->findWithoutFail($id);

        if (empty($parametro)) {
            Flash::error('Parametro not found');

            return redirect(route('parametros.index'));
        }

        $this->parametroRepository->delete($id);

        Flash::success('Parametro deleted successfully.');

        return redirect(route('parametros.index'));
    }

}
