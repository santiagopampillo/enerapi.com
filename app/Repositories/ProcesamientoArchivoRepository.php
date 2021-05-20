<?php

namespace App\Repositories;

use App\ProcesamientoArchivo;
use App\DatoDDJJ;
use App\ImportDatoDDJJ;
use InfyOm\Generator\Common\BaseRepository;


class ProcesamientoArchivoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anio',
        'codigo',
        'mes',
        'fecha',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProcesamientoArchivo::class;
    }   

    
    public function getByFilter($pagination,$filters,$with=null){
        $query = $this->model->newQuery();

        if ($with!=null){
            $query = $this->model->newQuery()->with($with);
        }

        foreach ($filters as $key => $value) {
            if ($value!=""){
                if (substr($key, -3) == "_id"){
                    $query = $query->where($key,$value);        
                }else{
                     $query = $query->where($key,"like","%" . $value . "%");        
                }                
            }
        }

        $query->orderBy('created_at');

        if (is_null($pagination)){
            return $query = $query->get();
        }else{
            return $query = $query->paginate($pagination);    
        }
        
    }   


    public function existeProcesamientoArchivoPorEstado($anio, $mes, $codigo, $estado){
        //$procesamiento = $this->model->newQuery()->where('anio','=',$anio);
        $procesamiento = ProcesamientoArchivo::where('anio','=',$anio);
        $procesamiento = $procesamiento->where('mes','=',$mes);
        $procesamiento = $procesamiento->where('codigo','=', $codigo);
        $procesamiento = $procesamiento->where('estado','=', $estado)->count();

        return $procesamiento;
    }

    public function crearProcesamientoArchivoEstado($anio, $mes, $codigo, $estado, $estado_proceso_datos, $empresa_id){
        $procesamientoEstado = new ProcesamientoArchivo;
        $procesamientoEstado->anio = $anio;
        $procesamientoEstado->codigo = $codigo;
        $procesamientoEstado->mes = $mes;
        $procesamientoEstado->fecha = date('Y-m-d h:i:s');
        $procesamientoEstado->estado = $estado;
        $procesamientoEstado->empresa_id = $empresa_id;
        $procesamientoEstado->estado_proceso_datos = $estado_proceso_datos;
        $procesamientoEstado->save();
        return $procesamientoEstado->id;
    }    

    public function finalizarProcesamiento($procesamiento_id){

        $procesamiento = ProcesamientoArchivo::find($procesamiento_id);
        $procesamiento->estado_proceso_datos = 'Finalizado';
        $procesamiento->save();

    }


    public function archivosBajadosSinProcesar($anio, $mes){
        $sinProcesar = ProcesamientoArchivo::where('anio','=',$anio);
        $sinProcesar = $sinProcesar->where('mes','=',$mes);
        $sinProcesar = $sinProcesar->where('estado_proceso_datos','=', "Pendiente");
        $sinProcesar = $sinProcesar->where('estado','=', "Fin bajada de archivo")
                            ->select("codigo", "anio", "mes", "empresa_id", "id")
                            ->orderBy("codigo")
                            ->get();

        return $sinProcesar;
    }

    public function procesar($nombreArchivo, $anio, $mes, $empresa_id, $procesamiento_id){

        //Borro datos de la tabla de datos_ddjj, por si se corto en el medio de los insert
        DatoDDJJ::where('anio', $anio)->where('mes', $mes)->where('empresa_id', $empresa_id)->delete();
        //fin borrado

        $doc = new \DOMDocument();
        //$doc->loadHTMLFile(storage_path("app\\".$nombreArchivo), LIBXML_PARSEHUGE);
	$doc->loadHTMLFile(storage_path("app/".$nombreArchivo), LIBXML_PARSEHUGE);

        \Log::info('lecutra xls (formato html) => '.$nombreArchivo);

        $elements = $doc->getElementsByTagName('tr');
        //$elements = $doc->getElementsByTagName('table');
        if (!is_null($elements)) {
            $iFil=0;
            foreach ($elements as $element) {
                if($iFil>1){
                    if(count($arrayDatos) == 35){
                        $cuenca = ($arrayDatos[0])?$arrayDatos[0]:null;
                        $provincia = ($arrayDatos[1])?$arrayDatos[1]:null;
                        $area = ($arrayDatos[2])?$arrayDatos[2]:null;
                        $yacimiento = ($arrayDatos[3])?$arrayDatos[3]:null;
                        $id_pozo = ($arrayDatos[4])?$arrayDatos[4]:null;
                        $sigla = ($arrayDatos[5])?$arrayDatos[5]:null;
                        $form_prod = ($arrayDatos[6])?$arrayDatos[6]:null;
                        $cod_propio = ($arrayDatos[7])?$arrayDatos[7]:null;
                        $nom_propio = ($arrayDatos[8])?$arrayDatos[8]:null;
                        $prod_men_pet = ($arrayDatos[9])?$arrayDatos[9]:0;
                        $prod_men_gas = ($arrayDatos[10])?$arrayDatos[10]:0;
                        $prod_men_agua = ($arrayDatos[11])?$arrayDatos[11]:0;
                        $prod_acum_pet = ($arrayDatos[12])?$arrayDatos[12]:0;
                        $prod_acum_gas = ($arrayDatos[13])?$arrayDatos[13]:0;
                        $prod_acum_agua = ($arrayDatos[14])?$arrayDatos[14]:0;
                        $iny_agua = ($arrayDatos[15])?$arrayDatos[15]:0;
                        $iny_gas = ($arrayDatos[16])?$arrayDatos[16]:0;
                        $iny_cO2 = ($arrayDatos[17])?$arrayDatos[17]:0;
                        $iny_otros = ($arrayDatos[18])?$arrayDatos[18]:0;
                        $rgp = ($arrayDatos[19])?$arrayDatos[19]:0;
                        $porc_de_agua = ($arrayDatos[20])?$arrayDatos[20]:0;
                        $tef = ($arrayDatos[21])?$arrayDatos[21]:0;
                        $vida_util = ($arrayDatos[22])?$arrayDatos[22]:0;
                        $sist_extrac = ($arrayDatos[23])?$arrayDatos[23]:null;
                        $est_pozo = ($arrayDatos[24])?$arrayDatos[24]:null;
                        $tipo_pozo = ($arrayDatos[25])?$arrayDatos[25]:null;
                        $clasificacion = ($arrayDatos[26])?$arrayDatos[26]:null;
                        $sub_clasificacion = ($arrayDatos[27])?$arrayDatos[27]:null;
                        $tipo_de_recurso = ($arrayDatos[28])?$arrayDatos[28]:null;
                        $sub_tipo_de_recurso = ($arrayDatos[29])?$arrayDatos[29]:null;
                        $observaciones = ($arrayDatos[30])?$arrayDatos[30]:null;
                        $latitud = ($arrayDatos[31])?$arrayDatos[31]:null;
                        $longitud = ($arrayDatos[32])?$arrayDatos[32]:null;
                        $cota = ($arrayDatos[33])?$arrayDatos[33]:null;
                        $profundidad = ($arrayDatos[34])?$arrayDatos[34]:null;

                        if($id_pozo){
                            $data[]=array('procesamiento_id'=>$procesamiento_id, 'empresa_id'=>$empresa_id, 'mes'=>$mes, 'anio'=>$anio, 'nombre_archivo'=>$nombreArchivo, 
                                            'cuenca'=>$cuenca, 
                                            'provincia'=>$provincia, 'area'=>$area, 'yacimiento'=>$yacimiento, 'id_pozo'=>$id_pozo, 'sigla'=>$sigla, 
                                            'form_prod'=>$form_prod, 'cod_propio'=>$cod_propio, 'nom_propio'=>$nom_propio, 'prod_men_pet'=>$prod_men_pet, 
                                            'prod_men_gas'=>$prod_men_gas, 'prod_men_agua'=>$prod_men_agua, 'prod_acum_pet'=>$prod_acum_pet, 
                                            'prod_acum_gas'=>$prod_acum_gas, 'prod_acum_agua'=>$prod_acum_agua, 'iny_agua'=>$iny_agua, 
                                            'iny_gas'=>$iny_gas, 'iny_cO2'=>$iny_cO2, 'iny_otros'=>$iny_otros, 'rgp'=>$rgp, 
                                            'porc_de_agua'=>$porc_de_agua, 'tef'=>$tef, 'vida_util'=>$vida_util, 'sist_extrac'=>$sist_extrac, 
                                            'est_pozo'=>$est_pozo, 'tipo_pozo'=>$tipo_pozo, 'clasificacion'=>$clasificacion, 
                                            'sub_clasificacion'=>$sub_clasificacion, 'tipo_de_recurso'=>$tipo_de_recurso, 
                                            'sub_tipo_de_recurso'=>$sub_tipo_de_recurso, 'observaciones'=>$observaciones, 
                                            'latitud'=>$latitud, 'longitud'=>$longitud, 'cota'=>$cota, 'profundidad'=>$profundidad);
                        }

                        if(count($data)>50){
                            \Log::info('chrunk');
                            DatoDDJJ::insert($data); 
                            $data=array();
                        }
                    }
                }

                $nodes = $element->childNodes;

                $iCol=0;
                $arrayDatos=array();
                foreach ($nodes as $node) {
                    $valor = str_replace("\t\t\t\t", "", $node->nodeValue);
                    $valor = str_replace("\r\n", "", $valor);
                    $valor = str_replace("                ", "---", $valor);
                    $valor = str_replace("\t\t\t", "---", $valor);
                    if($valor !="---" ){
                        $arrayDatos[$iCol] = $valor;
                        $iCol++;
                    }
                }
                $iFil++;
            }
            if(count($data)>0)
                DatoDDJJ::insert($data);
        }

        \Log::info('Fin lectura e insert datos => '.$nombreArchivo);
    }
}
