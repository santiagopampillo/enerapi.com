@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inbox de Análisis Crediticio</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
    @include('flash::message')
      <div class="container-fluid">

            <div class="card card-default card-outline">
                <div class="card-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                        <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                                                <th style="text-align: center;width: 130px">Acciones</th>
                                                <th>CUIL</th>
                                                <th>Alta</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Celular</th>
                                                <th>Tipo de haberes</th>
                                                <th>Banco</th>
                                                <th>Ingresos</th>
                                                <th>Monto solicitado</th>
                                                <th>Plan aprobado</th>
                                                <th>ID Solicitud</th>
                                                <th>Docs</th>
                                        </tr>
                                        @foreach($registros as $registro)
                                        <tr>
                                                <td nowrap style="text-align: center;width: 130px">
                                                        {!! Form::open(['route' => ['solicitudes.rechazar', $registro->id], 'method' => 'post']) !!}
                                                        <a href="{!! route('solicitudes.ofertar', [$registro->id]) !!}" class="btn btn-sm btn-ok" style="padding: 1px 5px 0px 5px;height: 25px;">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        <button type="submit" class="btn btn-sm btn-delete" style="    padding: 0px 5px 0px 5px;height: 25px;" onclick="return confirm('¿Estás seguro?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>                                    
                                                        {!! Form::close() !!}                                                 
                                                </td>
                                            <td>{!! $registro->cuil !!}</td>
                                            <td>{!! \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y'); !!}</td>
                                            <td>{!! $registro->nombre . ' ' .  $registro->apellido!!}</td>
                                            <td>{!! $registro->email!!}</td>
                                            <td>{!! $registro->codarea . '-' . $registro->celular!!}</td>
                                            <td>{!! $registro->tipo_haberes->nombre!!}</td>
                                            <td>{!! $registro->banco->nombre!!}</td>
                                            <td>${!! number_format($registro->ingresos,0,',','.')!!}</td>
                                            <td>${!! number_format($registro->monto,0,',','.')!!}</td>
                                            <td>{!! $registro->plan_no_digital->nombre!!}</td>
                                            <td>{!! $registro->solicitud_gescred!!}</td>
                                            <td><a href='{{env("GOOGLE_DRIVE_URL") . $registro->gdrive_folder_docs}}' target="_blank"><i class="far fa-folder-open"></i></a></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            

                        </div>
                        
                </div>
                <div class="card-footer clearfix text-center">
                <?php echo $registros->appends(request()->except('page'))->links(); ?>
              </div>
        </div>




      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
@endsection  
@section('scripts')
    <script src="{{ asset('js/admin/index.js')}}"></script>
@endsection