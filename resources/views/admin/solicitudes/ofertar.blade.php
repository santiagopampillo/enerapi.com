@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Solicitud</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')

        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Realizar oferta</h3>          
            </div>
            {!! Form::model($registro, ['id'=>'frm','route' => ['solicitudes.oferta_store', $registro->id], 'method' => 'post']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('monto_ofrecido', 'Monto máximo:') !!}
                        {!! Form::number('monto_ofrecido', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-sm-6">
                            {!! Form::label('monto_cuota_ofrecida', 'Cuota máxima:') !!}
                            {!! Form::number('monto_cuota_ofrecida', null, ['class' => 'form-control']) !!}
                        </div>
                </div>
            </div>
            <div class="card-footer text-right">
                {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
                <a href="{!! route('solicitudes.inbox_analisis_crediticio') !!}" class="btn btn-sm btn-info">Cancelar</a>
            </div>
            {!! Form::close() !!}

        </div>
   </div>
@endsection
@section('scripts')
<script>
var _errores = '';
$(function(){
	$('#frm').on('submit', function() {
		_errores = '';
        if($('#monto_ofrecido').val() == '' && $('#monto_cuota_ofrecida').val() == '') {
            _errores += '<li>Debe ingresar monto máximo y/o cuota máxima</li>';
        }
		
		if(_errores!='') {
			$('.content').find('.alert-danger').first().remove();
			$('.content').prepend('<ul class="alert alert-danger" style="list-style-type: none">' + _errores + '</ul>');
			return false;
		}
	
    
	});

});
</script>
@endsection