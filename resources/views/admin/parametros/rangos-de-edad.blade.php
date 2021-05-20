<!-- Nombre Field -->
<?php 
	if ($valores!=""){
		$edad_minima = $valores[0];
		$edad_maxima = $valores[1];
	}else{
		$edad_minima = "";
		$edad_maxima = "";
	}
?>
<div class="card-body">
	<div class="row">
		<div class="form-group col-sm-6">
		    {!! Form::label('edad_minima', 'Edad mínima:') !!}
		    {!! Form::number('edad_minima', $edad_minima, ['class' => 'form-control']) !!}
		</div>

		<!-- Valores Field -->
		<div class="form-group col-sm-6">
		    {!! Form::label('edad_maxima', 'Edad máxima:') !!}
		    {!! Form::number('edad_maxima', $edad_maxima, ['class' => 'form-control']) !!}
		</div>

	</div>
</div>
<div class="card-footer text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
</div>
@section('scripts')
	<script>
		var _errores = '';
		$(function(){
			$('#frm').on('submit', function() {
				$('.content').find('.alert-danger').first().remove();
				$('.content').find('.alert-success').first().remove();
				_errores = '';
		        if($('#edad_minima').val() == '') {
		            _errores += '<li>El campo edad mínima es requerido</li>';
		        }else{
		        	if($('#edad_minima').val()<18){
		        		_errores += '<li>La edad mínima debe ser mayor o igual a 18 años</li>';	
		        	}
		        }
		        if($('#edad_maxima').val() == '') {
		            _errores += '<li>El campo edad máxima es requerido</li>';
		        }else{
					if ($('#edad_minima').val()!=""){
						if ($('#edad_maxima').val()< $('#edad_minima').val()){
							_errores += '<li>La edad máxima no puede ser menor a la mínima</li>';
						}
					}
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