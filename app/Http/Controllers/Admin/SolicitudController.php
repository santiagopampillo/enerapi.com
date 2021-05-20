<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateSolicitudRequest;
use App\Http\Requests\Admin\UpdateSolicitudRequest;
use App\Repositories\SolicitudRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Solicitud;
use Carbon\Carbon;
use Excel;
use App\Services\AhoraCashService;
use App\PlanComercial;
use App\TipoRechazo;

class SolicitudController extends AppBaseController
{
    /** @var  SolicitudRepository */
    private $solicitudRepository;
    private $ahoraCashService;

    public function __construct(SolicitudRepository $solicitudRepo,AhoraCashService $ahoraCashService)
    {
        $this->solicitudRepository = $solicitudRepo;
        $this->ahoraCashService = $ahoraCashService;
    }

    /**
     * Display a listing of the Solicitud.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->solicitudRepository->pushCriteria(new RequestCriteria($request));
        $solicituds = $this->solicitudRepository->all();

        return view('admin.solicitudes.index')
            ->with('solicituds', $solicituds);
    }

    public function inbox_analisis_crediticio(Request $request)
    {
        $pagination = (\Request::input('export')==0) ? 100 : null;

        $filtros = [];
        $filtros['estado_id'] = 6;
        $with = ['plan_no_digital','tipo_haberes','banco'];

        $registros = $this->solicitudRepository->getByFilter($pagination,$filtros,$with);
        if (\Request::input('export')==0){
            return view('admin.solicitudes.inbox_analisis_crediticio')
                ->with('registros', $registros)->with('filtros', $filtros);
        }    
    }    

    /**
     * Show the form for creating a new Solicitud.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.solicituds.create');
    }

    /**
     * Store a newly created Solicitud in storage.
     *
     * @param CreateSolicitudRequest $request
     *
     * @return Response
     */
    public function store(CreateSolicitudRequest $request)
    {
        $input = $request->all();

        $solicitud = $this->solicitudRepository->create($input);

        Flash::success('Solicitud saved successfully.');

        return redirect(route('solicitudes.index'));
    }

    /**
     * Display the specified Solicitud.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.index'));
        }

        return view('admin.solicituds.show')->with('solicitud', $solicitud);
    }

    /**
     * Show the form for editing the specified Solicitud.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.index'));
        }

        return view('admin.solicituds.edit')->with('solicitud', $solicitud);
    }

    public function ofertar($id)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.inbox_analisis_crediticio'));
        }

/*         $planes = PlanComercial::orderBy('id')->get();
        $this->comboPlanes= ['0' => 'Seleccionar'];
        foreach($planes as $p) {
            $this->comboPlanes[$p->id] = $p->nombre;
        }

        $solicitud->codigo_gescred = null; */
        $solicitud->monto_ofrecido = null;
        $solicitud->monto_cuota_ofrecida = null;

        return view('admin.solicitudes.ofertar')->with('registro', $solicitud);
    }

    public function oferta_store($id, Request $request)
    {
        $input = $request->all();

        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.inbox_analisis_crediticio'));
        }

        $solicitud->codigo_gescred = $solicitud->prestamo_no_digital;
        $solicitud->monto_ofrecido = $input['monto_ofrecido'];
        $solicitud->monto_cuota_ofrecida = $input['monto_cuota_ofrecida'];
        $solicitud->estado_id = 11;
        $solicitud->save();

        $streak_params["link_oferta_final"] = route('continuar_cargando',md5($solicitud->id));
        $streak_params["stage"] = 'OFERTA_FINAL';
        $this->ahoraCashService->update_streak_box($solicitud->streak_box_key,$streak_params);

        $data['nombre'] = $solicitud->nombre . ' '. $solicitud->apellido;
        $data['link'] = route('continuar_cargando',md5($solicitud->id));
        if ($solicitud!=null){
            \Mail::send('emails.prestamo_no_digital', $data, function($message) use ($solicitud) {
                $message->to($solicitud->email);
                $message->subject('Smartcash: Continuar con la carga');
            });
        }

        Flash::success('Se envió un mail al solicitante para que continue con la confirmación de la oferta');

        return redirect(route('solicitudes.inbox_analisis_crediticio'));
    }

    /**
     * Update the specified Solicitud in storage.
     *
     * @param  int              $id
     * @param UpdateSolicitudRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSolicitudRequest $request)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.index'));
        }

        $solicitud = $this->solicitudRepository->update($request->all(), $id);

        Flash::success('Solicitud updated successfully.');

        return redirect(route('solicitudes.index'));
    }

    /**
     * Remove the specified Solicitud from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.index'));
        }

        $this->solicitudRepository->delete($id);

        Flash::success('Solicitud deleted successfully.');

        return redirect(route('solicitudes.index'));
    }

    public function rechazar($id)
    {
        $solicitud = $this->solicitudRepository->findWithoutFail($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicitudes.inbox_analisis_crediticio'));
        }

        $streak_params["stage"] = 'RECHAZADOS';
        $this->ahoraCashService->update_streak_box($solicitud->streak_box_key,$streak_params);
        $solicitud->estado_id=12;
        $solicitud->save();
        
        $data['nombre'] = $solicitud->nombre . ' '. $solicitud->apellido;
        \Mail::send('emails.solicitud_rechazada', $data, function($message) use ($solicitud) {
            $message->to($solicitud->email);
            $message->subject('Smartcash: Solicitud rechazada');
        });
        Flash::success('La solicitud ha sido rechazada');

        return redirect(route('solicitudes.inbox_analisis_crediticio'));
    }

    public function reporteProvincias(Request $request)
    {
        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        if ($filters["via_ingreso"]!=2){        
            $registros = Solicitud::with('provincia')->where("estado_id","<>",null);
        
            if (\Request::input('fecha_desde')!=""){
                $registros = $registros->whereDate('created_at','>=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d'));
            }
            if (\Request::input('fecha_hasta')!=""){
                $registros = $registros->whereDate('created_at','<=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d'));
            }

            $registros = $registros->groupBy("provincia_id")->select("provincia_id",\DB::raw("COUNT(*) as cant"))->orderBy(\DB::raw("COUNT(*)"),"desc")->get();

        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.provincias')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['PROVINCIA','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->provincia->nombre,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
    }

    public function reporteTipoHaberes(Request $request)
    {
        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        if ($filters["via_ingreso"]!=2){        
            $registros = Solicitud::with('tipo_haberes')->where("estado_id","<>",null)->where("tipo_haberes_id","<>",null);
            if (\Request::input('fecha_desde')!=""){
                $registros = $registros->whereDate('created_at','>=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d'));
            }
            if (\Request::input('fecha_hasta')!=""){
                $registros = $registros->whereDate('created_at','<=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d'));
            }

            $registros = $registros->groupBy("tipo_haberes_id")->select("tipo_haberes_id",\DB::raw("COUNT(*) as cant"))->orderBy(\DB::raw("COUNT(*)"),"desc")->get();

        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.tipo_haberes')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['TIPO DE HABERES','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->tipo_haberes->nombre,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
        
    }

    public function reporteNivelDemanda(Request $request)
    {
        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        if ($filters["via_ingreso"]!=2){        
            $registros = Solicitud::where("estado_id","<>",null);
            if (\Request::input('fecha_desde')!=""){
                $registros = $registros->whereDate('created_at','>=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d'));
            }
            if (\Request::input('fecha_hasta')!=""){
                $registros = $registros->whereDate('created_at','<=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d'));
            }

            $registros = $registros->groupBy(\DB::raw("HOUR(created_at)"))->select(\DB::raw("HOUR(created_at) AS hora"),\DB::raw("COUNT(*) as cant"))->orderBy(\DB::raw("HOUR(created_at)"),"asc")->get();
        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.nivel_demanda')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['HORA','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->hora,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
    }    

    public function reporteNivelIngresos(Request $request)
    {
        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        $filtro_fechas = '';
        if (\Request::input('fecha_desde')!=""){
            $filtro_fechas = "AND date(created_at)>='" . Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d') . "'";
        }
        if (\Request::input('fecha_hasta')!=""){
            $filtro_fechas = " AND date(created_at)<='" . Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d') . "'";
        }

        if ($filters["via_ingreso"]!=2){        
            $sql = "SELECT price_range, COUNT(*) AS cant
            FROM
            (SELECT CASE WHEN ingresos < 10000 THEN 'Menor a $10.000'
                     WHEN ingresos >= 10001 AND ingresos <= 20000 THEN 'Entre $10.000 a $20.000'
                         WHEN ingresos >= 20001 AND ingresos <= 30000 THEN 'Entre $20.001 a $30.000'
                         WHEN ingresos >= 30001 AND ingresos <= 40000 THEN 'Entre $30.001 a $40.000'
                     WHEN ingresos >= 40001 AND ingresos <= 50000 THEN 'Entre $40.001 a $50.000'
                     WHEN ingresos >= 50001 AND ingresos <= 65000 THEN 'Entre $50.001 a $65.000'	     
                     WHEN ingresos >= 65001 AND ingresos <= 85000 THEN 'Entre $65.001 a $85.000'	     
                         WHEN ingresos >= 85001 THEN 'Más de $85.001'                          
                     END AS price_range
            FROM solicitudes
            WHERE estado_id IS NOT null " . $filtro_fechas . ") AS  price_summaries
            GROUP BY price_range ";


            $registros = \DB::select($sql);
        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.nivel_ingresos')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['NIVEL DE INGRESOS','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->price_range,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
    }

    public function reporteMotivosRechazo(Request $request)
    {
        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');
        $filters["cuil"]        = \Request::input('cuil');
        $tipos_rechazo = null;

        if ($filters["cuil"]!=""){
            $tipos_rechazo = TipoRechazo::orderBy('id')->get();    
            if ($filters["via_ingreso"]!=2){        
                $registros = Solicitud::with('rechazos')->where("estado_id","<>",null)->where('cuil',$filters["cuil"]);
                if (\Request::input('fecha_desde')!=""){
                    $registros = $registros->whereDate('created_at','>=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d'));
                }
                if (\Request::input('fecha_hasta')!=""){
                    $registros = $registros->whereDate('created_at','<=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d'));
                }
                $registros = $registros->orderBy('id')->get();
            }
            else{
                $registros = [];
            }
        }else{
            $filtro_fechas = '';
            if (\Request::input('fecha_desde')!=""){
                $filtro_fechas = "AND date(s.created_at)>='" . Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d') . "'";
            }
            if (\Request::input('fecha_hasta')!=""){
                $filtro_fechas = " AND date(s.created_at)<='" . Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d') . "'";
            }
    
            if ($filters["via_ingreso"]!=2){        
                $sql = "SELECT tr.nombre,COUNT(*) as cant FROM solicitudes s 
                INNER JOIN solicitudes_rechazos r ON s.id = r.solicitud_id
                INNER JOIN tipos_rechazo tr ON tr.id = r.rechazo_id
                WHERE s.estado_id IS NOT NULL " . $filtro_fechas . " GROUP BY tr.nombre ORDER BY COUNT(*) DESC";
    
                $registros = \DB::select($sql);
            }
            else{
                $registros = [];
            }
        }

        
        if (\Request::input('export')==0){
            return view('admin.reportes.motivos_rechazo')->with('registros', $registros)->with($filters)->with('tipos_rechazo',$tipos_rechazo);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['ESTADO','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->nombre,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
    }

    public function reporteNivelActividad(Request $request)
    {
        $filters = [];
        $filters["periodo"] = \Request::input('periodo');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        if ($filters["via_ingreso"]!=2){        
            $registros = Solicitud::with('estado')->where("estado_id","<>",null);
            
            switch ($filters["periodo"]){
                case 1:
                    $registros = $registros->whereDate('created_at',Carbon::today());
                    break;
                case 2:
                    $registros = $registros->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 3:
                    $registros = $registros->whereDate('created_at','>=',Carbon::now()->startOfMonth());
                    break;
                case 4:
                    $date = Carbon::today()->subDays(30);
                    $registros = $registros->whereDate('created_at','>=',$date);
                    break;
            }

        
            $registros = $registros->groupBy("estado_id")->select("estado_id",\DB::raw("COUNT(*) as cant"))->orderBy(\DB::raw("COUNT(*)"),"desc")->get(); 


        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.nivel_actividad')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['ESTADO','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->estado->nombre,$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }
        

    }

    public function reporteEndeudamientoVsSueldoNeto(Request $request)
    {

        $filters = [];
        $filters["fecha_desde"] = \Request::input('fecha_desde');
        $filters["fecha_hasta"] = \Request::input('fecha_hasta');
        $filters["via_ingreso"] = \Request::input('via_ingreso');

        if ($filters["via_ingreso"]!=2){        
            $registros = Solicitud::where("estado_id","<>",null);
        
            if (\Request::input('fecha_desde')!=""){
                $registros = $registros->whereDate('created_at','>=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_desde'))->format('Y-m-d'));
            }
            if (\Request::input('fecha_hasta')!=""){
                $registros = $registros->whereDate('created_at','<=',Carbon::CreateFromFormat('d/m/Y',\Request::input('fecha_hasta'))->format('Y-m-d'));
            }

            $registros = $registros->groupBy("end_vs_sueldo")->select("end_vs_sueldo",\DB::raw("COUNT(*) as cant"))->orderBy(\DB::raw("COUNT(*)"),"desc")->get();

        }
        else{
            $registros = [];
        }
        
        if (\Request::input('export')==0){
            return view('admin.reportes.endeudamiento_vs_sueldo_neto')->with('registros', $registros)->with($filters);
        }else{
            $registrosArray = [];

            $registrosArray[] = ['PROPORCION','SOLICITUDES'];    
            foreach ($registros as $r) {
                $registrosArray[] = array($r->end_vs_sueldo . 'x',$r->cant);
            }

            Excel::create('reporte', function($excel) use($registrosArray) {
                $excel->sheet('Hoja 1', function($sheet) use($registrosArray) {
                    $sheet->fromArray($registrosArray,null,'A1',false,false);
                });
            })->export('xls');
        }        
    }
}
