@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{!! asset('plugins/datepicker/datepicker3.css') !!}">
@endsection
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Endeudamiento vs sueldo neto</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      @include('flash::message')
      <div class="container-fluid">
        <div class="card card-default card-outline">
            <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>

                    <div class="card-tools" >
                        <a href="javascript:void(0)" class="btn btn-sm" id="btnExportar" style="background-color: #242424;border-color: #242424;color:#fff;">
                        <i class="fa fa-download"></i>&nbsp;Exportar
                        </a>
                    </div>
                    <!-- /.card-tools -->
            </div>
            <div class="card-body">
                <form id="frm">
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label>Fecha desde</label>
                                <input type="text" name="fecha_desde" id="fecha_desde" class="form-control" autocomplete="false" value="{{$fecha_desde}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label>Fecha hasta</label>
                                <input type="text" name="fecha_hasta" id="fecha_hasta" class="form-control" autocomplete="false" value="{{$fecha_hasta}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label>Via de ingreso</label>
                                <select name="via_ingreso" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Web</option>
                                    <option value="2">Red de comercializadores</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="page" value="1">
                    <input type="hidden" name="export" id="export" value="0">
                    <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="fa fa-search"></i>&nbsp;Buscar
                                </button>
                            </div>
                    </div>       
                </form>         
            </div>
        </div>
        <div class="card card-default card-outline">
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                                <th>Proporción</th>
                                <th>Solicitudes</th>
                            </tr>
                            @foreach ($registros as $item)
                                <tr>
                                    <td>{{$item->end_vs_sueldo}}x</td>
                                    <td>{{$item->cant}}</td>
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                </div>                        
            </div>
            <div class="card-footer clearfix text-center">
            
            </div>
        </div>
      </div><!--/. container-fluid -->
    </section>

    <!-- /.content -->
  
  <!-- /.content-wrapper -->
@endsection  
@section('scripts')
    <script type="text/javascript" src="{!! asset('plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('plugins/datepicker/locales/bootstrap-datepicker.es.js') !!}"></script>
    <script>
    $(function() {
        $( "#fecha_desde,#fecha_hasta" ).datepicker({ format: 'dd/mm/yyyy', autoclose: true,  language: 'es' });
    });
    </script>
    <script src="{{ asset('js/admin/index.js')}}"></script>
@endsection