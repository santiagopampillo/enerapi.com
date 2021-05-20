<?php

namespace App\Http\Controllers;

use App\Services\PozoService;
use App\Repositories\EmpresaRepository;
use App\Repositories\ProcesamientoArchivoRepository;
use App\Repositories\ProcesamientoRepository;
use Illuminate\Http\Request;
use App\Empresa;
use App\ProcesamientoArchivo;
use App\Procesamiento;

class PozosController extends Controller
{
    private $pozoService;
    private $empresaRepository;
    private $procesamientoArchivoRepository;
    private $procesamientoRepository;

    /**
     * BancoController constructor.
     * @param $bancoService
     */
    public function __construct(PozoService $pozoService, EmpresaRepository $empresaRepository, ProcesamientoArchivoRepository $procesamientoArchivoRepository, ProcesamientoRepository $procesamientoRepository)
    {
        $this->pozoService = $pozoService;
        $this->empresaRepository = $empresaRepository;
        $this->procesamientoArchivoRepository = $procesamientoArchivoRepository;
        $this->procesamientoRepository = $procesamientoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->pozoService->processPozos();
    }

    public function bajarArchivos()
    {
        //Busco un mes anterior al actual
        $anio = date('Y');
        ////$mes = (int)date('m')-1;

        $mes = (int) date('m')-(int)\Config::get('constants.constantes.mes_proceso');
        if($mes == 0){
            $anio = $anio - 1;
            $mes = 1;
        }        

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        ini_set('default_socket_timeout', 600);
        ini_set('upload_max_filesize ', '40M');
        ini_set('post_max_size ', '40M');
            
        $empresas = Empresa::all()->sortBy("codigo");

        //Ver con tavo como seria la query para no traer TODOS

        $i=0;
        $msg="";
        foreach ($empresas as $empresa) {
            //Veo si existe un procesamiento para el anio, mes, codigo
            //$existeProcesamientoArchivoFinalizado = ProcesamientoArchivo::where('anio','=',$anio)->where('mes','=',$mes)->where('codigo','=', $empresa->codigo)->where('estado','=', 'Finalizado')->count();
            $existeProcesamientoArchivoFinalizado = $this->procesamientoArchivoRepository->existeProcesamientoArchivoPorEstado($anio, $mes, $empresa->codigo, "Fin bajada de archivo");
            if($existeProcesamientoArchivoFinalizado == 0){
                //if($i<4 && $empresa->codigo!="YPF"){
                if($i<6){
                    $i++;
                    $this->procesamientoArchivoRepository->crearProcesamientoArchivoEstado($anio, $mes, $empresa->codigo, "Inicio bajada de archivo", "", $empresa->id);

                    $PozoService = new PozoService($anio, $empresa->codigo, $mes);
                    \Log::info('init descarga');
                    $nombreArchivo = $anio."-".$mes."-".$empresa->codigo."-ddjj.xlsx";

                    $msg.="Codigo empresa bajado ==> ".$empresa->codigo;

                    $excel = $PozoService->processPozos($nombreArchivo);
                    \Log::info('fin descarga');
                    
                    $this->procesamientoArchivoRepository->crearProcesamientoArchivoEstado($anio, $mes, $empresa->codigo, "Fin bajada de archivo", "Pendiente", $empresa->id);
                    if($excel == ""){
                        $msg.=" ==> No existe excel para esta empresa en este mes.";
                        $this->procesamientoArchivoRepository->crearProcesamientoArchivoEstado($anio, $mes, $empresa->codigo, "No hay DDJJ (sin Excel)", "", $empresa->id);                    
                    } 
                    $msg.="<br>";
                }
            }
        } 

        if($i==0)
            echo "No quedan archivos por bajar este mes";
        else
            echo "Se bajaron ".$i." archivos. ".$msg." Aun quedan archivos por bajar";
    }    


    public function procesarDatos()
    {
        //Busco un mes anterior al actual
        $anio = date('Y');
        ////$mes = (int)date('m')-1;
        $mes = (int) date('m')-(int)\Config::get('constants.constantes.mes_proceso');
        if($mes == 0){
            $anio = $anio - 1;
            $mes = 1;
        }        


        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        ini_set('default_socket_timeout', 600);
        ini_set('upload_max_filesize ', '40M');
        ini_set('post_max_size ', '40M');

        //$empresas = Empresa::all();
        $procesamientos_sin_procesar = $this->procesamientoArchivoRepository->archivosBajadosSinProcesar($anio, $mes);
        $i=0;
        foreach ($procesamientos_sin_procesar as $procesamiento) {
            if($i<1){
                $PozoService = new PozoService($anio, $procesamiento->codigo, $mes);
                //\Log::info('init descarga');
                $nombreArchivo = $anio."-".$mes."-".$procesamiento->codigo."-ddjj.xlsx";
//                if(!file_exists(storage_path("app\\".$nombreArchivo))){
                  if(!file_exists(storage_path("app/".$nombreArchivo))){
                    $this->procesamientoRepository->crearProcesamientoEstado($anio, $mes, $procesamiento->codigo, "No existe archivo", $procesamiento->empresa_id, $procesamiento->id); 
                    $this->procesamientoRepository->crearProcesamientoEstado($anio, $mes, $procesamiento->codigo, "Finalizado", $procesamiento->empresa_id, $procesamiento->id); 
                    echo "no existe archivo ".$nombreArchivo."<br>";

                    $this->procesamientoArchivoRepository->finalizarProcesamiento($procesamiento->id);
                } else{
                    //PROCESAR EL XLS
                    $procesamiento_id = $this->procesamientoRepository->crearProcesamientoEstado($anio, $mes, $procesamiento->codigo, "Inicio Procesamiento Archivo", $procesamiento->empresa_id, $procesamiento->id);   

					//PONGO finalizado aunque no termine de procesar
                    $this->procesamientoArchivoRepository->finalizarProcesamiento($procesamiento->id);
                    //para q no quede colgado
					
                    $this->procesamientoRepository->procesar($nombreArchivo, $anio, $mes, $procesamiento->empresa_id, $procesamiento_id);

                    $this->procesamientoRepository->crearProcesamientoEstado($anio, $mes, $procesamiento->codigo, "Finalizado", $procesamiento->empresa_id, $procesamiento->id); 

                    ////$this->procesamientoArchivoRepository->finalizarProcesamiento($procesamiento->id);
                    
                    echo "finalizado ".$nombreArchivo."<br>";

                    $i++;
                }    
            }
        }

        if($i==0)
            echo "<br>No quedar archivos por procesar";
        else
            echo "Se procesaron ".$i." archivos. Aun quedan archivos para procesar";
    }    

}
