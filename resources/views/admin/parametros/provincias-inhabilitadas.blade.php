<?php 
	$provincias_seleccionadas = ($valores!="") ? implode(',',$valores) : '';
?>
<div class="card-body">
	<div class="row">
		<div class="form-group col-sm-6">
		    {!! Form::label('provincias', 'Seleccionar las provincias:') !!}
			<select class="form-control" id="provincias" name="provincias[]" multiple="multiple">
			  @foreach ($provincias as $provincia)
			  	<option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
			  @endforeach
			</select>
		</div>


	</div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
</div>
@section('scripts')
	<script>
		provincias_seleccionadas = '{{$provincias_seleccionadas}}';
		var _errores = '';
		$(function(){

    		
    		if (provincias_seleccionadas!=""){
    			array_provincias = provincias_seleccionadas.split(',');
    			$('#provincias').val(array_provincias);
    		}
    		$('#provincias').select2();


			$('#frm').on('submit', function() {
				_errores = '';
		        if($('#provincias').val() == '') {
		            _errores += '<li>Por favor, seleccionar al menos una provincia</li>';
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