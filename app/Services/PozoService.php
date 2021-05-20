<?php

namespace App\Services;

use Cache;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use Store;
use App\Empresa;

class PozoService
{
    public function __construct($anio=2019, $codigo='ALP', $mes= 1)
    {
        $this->config = [
            'base_uri'  =>  'https://www.se.gob.ar/datosupstream/consulta_avanzada/',
            'timeout'   =>  30,
            'query' => [
                'idanio' => $anio,
                'idempresa' => $codigo,
                'idmes' => $mes,
                'submit' => 'Ver',
            ],
            'http_errors' => false,
        ];
    }
/*
    public function __construct($anio, $codigo, $mes)
    {
        $this->config = [
            'base_uri'  =>  'https://www.se.gob.ar/datosupstream/consulta_avanzada/',
            'timeout'   =>  30,
            'query' => [
                'idanio' => $anio,
                'idempresa' => $codigo,
                'idmes' => $mes,
                'submit' => 'Ver',
            ],
            'http_errors' => false,
        ];
    }    
*/
    public function processPozos_Convierte_html_xls($name="ddjj.xls")
    {
        $url = 'listado.php';
        $client = new Client($this->config);
        $response = $client->request('POST', $url, [
            'query' =>  $client->getConfig('query')
        ]);

        $link_excel="";
        if ($response->getStatusCode() == 200) {
            $html = $response->getBody()->getContents();

            $pattern = '~[a-z]+://\S+~';
            
            if($num_found = preg_match_all($pattern, $html, $links))
            {
               echo "FOUND ".$num_found." LINKS:\n";
               foreach($links[0] as $link) {
                   if( strpos($link, 'wvw.se.gob.ar/') > 0) {
                       $link_excel = $link;
                       break;
                   }
               }
               echo "<br>";
            }

            if($link_excel!=""){
                $address = $link_excel;
                $contents = file_get_contents($link_excel);
                 
                    
                
               

                //$name = 'ddjj.xls';
                $path = storage_path("app");
                $nameAux="ddjj-tmp.html";
                
                //\Storage::put($nameAux, $contents);
                
                $contentsX = mb_convert_encoding($contents, 'HTML-ENTITIES', "UTF-8");
                $contentsX = str_replace("&#2013265923;", "&oacute;", $contentsX);
                $contentsX = str_replace("&#2013265933;", "&iacute;", $contentsX);
                $contentsX = str_replace("&#2013265929;", "&eacute;", $contentsX);
                $contentsX = str_replace("&#2013266113;", "&Aacute;", $contentsX);
                $contentsX = str_replace("&#2013265946;", "&Uacute;", $contentsX);
                $contentsX = str_replace("&#2013265921;", "&aacute;", $contentsX);
                $contentsX = str_replace("&#2013265937;", "&Ntilde;", $contentsX);
                $contentsX = str_replace("&#2013266093;", "", $contentsX);
                $contentsX = str_replace("&#2013266080;", " ", $contentsX);
                $contentsX = str_replace("&#2013266172;", "&Uuml;", $contentsX);
                $contentsX = str_replace("&#2013265948;", "&Uuml;", $contentsX);
                $contentsX = str_replace("&#2013266170;", "&uacute;", $contentsX);

                $contentsX = str_replace("M&S", "M AND S", $contentsX);
                $contentsX = str_replace("E&P", "M AND S", $contentsX);
                $contentsX = str_replace("Oil & Gas", "Oil and Gas", $contentsX);
                
                $contentsX = str_replace("</div>", "</b></div>", $contentsX);
                $contentsX = str_replace('<td align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"><b>Fin del reporte</b></td>', '<tr><td align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"><b>Fin del reporte</b></td>', $contentsX);

                $contentsX = str_replace(' bgcolor="#EEEEEE" align="left"', "", $contentsX);
                $contentsX = str_replace(' align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"', "", $contentsX);
                $contentsX = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/(<[^>]+) bgcolor=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/^[ \t]*[\r\n]+/m', '', $contentsX);

                \Storage::put($nameAux, $contentsX);
                                
                $inputFileType = 'HTML';
                $inputFileName = $path."/".$nameAux;
                $outputFileType = 'Excel2007';
                $outputFileName = $path."/".$name;
            
                $objPHPExcelReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objPHPExcelReader->load($inputFileName);

                $objPHPExcelWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
                $objPHPExcel = $objPHPExcelWriter->save($outputFileName);  

                \Storage::delete($nameAux);
             
            }
        }
        
        return $link_excel;
    }

    public function processPozos($name="ddjj.xls")
    {
        $url = 'listado.php';
        $client = new Client($this->config);
        $response = $client->request('POST', $url, [
            'query' =>  $client->getConfig('query')
        ]);

        $link_excel="";
        if ($response->getStatusCode() == 200) {
            $html = $response->getBody()->getContents();

            $pattern = '~[a-z]+://\S+~';
            
            if($num_found = preg_match_all($pattern, $html, $links))
            {
               echo "FOUND ".$num_found." LINKS:\n";
               foreach($links[0] as $link) {
                   if( strpos($link, 'wvw.se.gob.ar/') > 0) {
                       $link_excel = $link;
                       break;
                   }
               }
               echo "<br>";
            }

            if($link_excel!=""){
                $address = $link_excel;
                $contents = file_get_contents($link_excel);

                //$name = 'ddjj.xls';
                $path = storage_path("app");               
                
                $contentsX = mb_convert_encoding($contents, 'HTML-ENTITIES', "UTF-8");
                $contentsX = str_replace("&#2013265923;", "&oacute;", $contentsX);
                $contentsX = str_replace("&#2013265933;", "&iacute;", $contentsX);
                $contentsX = str_replace("&#2013265929;", "&eacute;", $contentsX);
                $contentsX = str_replace("&#2013266113;", "&Aacute;", $contentsX);
                $contentsX = str_replace("&#2013265946;", "&Uacute;", $contentsX);
                $contentsX = str_replace("&#2013265921;", "&aacute;", $contentsX);
                $contentsX = str_replace("&#2013265937;", "&Ntilde;", $contentsX);
                $contentsX = str_replace("&#2013266093;", "", $contentsX);
                $contentsX = str_replace("&#2013266080;", " ", $contentsX);
                $contentsX = str_replace("&#2013266172;", "&Uuml;", $contentsX);
                $contentsX = str_replace("&#2013265948;", "&Uuml;", $contentsX);
                $contentsX = str_replace("&#2013266170;", "&uacute;", $contentsX);

                $contentsX = str_replace("M&S", "M AND S", $contentsX);
                $contentsX = str_replace("E&P", "M AND S", $contentsX);
                $contentsX = str_replace("Oil & Gas", "Oil and Gas", $contentsX);
                
                $contentsX = str_replace("</div>", "</b></div>", $contentsX);
                $contentsX = str_replace('<td align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"><b>Fin del reporte</b></td>', '<tr><td align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"><b>Fin del reporte</b></td>', $contentsX);

                $contentsX = str_replace(' bgcolor="#EEEEEE" align="left"', "", $contentsX);
                $contentsX = str_replace(' align="center" bgcolor="#FFAF0F" valign="middle" nowrap="nowrap"', "", $contentsX);
                $contentsX = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/(<[^>]+) bgcolor=".*?"/i', '$1', $contentsX);
                $contentsX = preg_replace('/^[ \t]*[\r\n]+/m', '', $contentsX);

                $contentsX = str_replace("\t\t\t\t", "", $contentsX);
                $contentsX = str_replace("\r\n", "", $contentsX);

                \Storage::put($name, $contentsX);            
            }
        }
        
        return $link_excel;
    }
    


    public function empresas()
    {
        
    }

    public function processPozos2()
    {
        $url = 'listado.php';
        $client = new Client($this->config);
        $response = $client->request('POST', $url, [
            'query' =>  $client->getConfig('query')
        ]);

        if ($response->getStatusCode() == 200) {
            $html = $response->getBody()->getContents();

            $pattern = '~[a-z]+://\S+~';
            
            if($num_found = preg_match_all($pattern, $html, $links))
            {
                echo "FOUND ".$num_found." LINKS:\n";
               foreach($links[0] as $link) {
                   if( strpos($link, 'wvw.se.gob.ar/') > 0) {
                       $link_excel = $link;
                       break;
                   }
               }
            }

            echo $link_excel;

            $contents = file_get_contents($link_excel);
            $name = 'ddjj.xls';
            \Storage::put($name, $contents);
        }
        
        return null;
    }
}