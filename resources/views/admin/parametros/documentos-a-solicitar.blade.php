<?php $fila = 1;?>

<div class="card-body">
	<div class="row">
		<div class="col-sm-12">
		<div class="card">
              <div class="card-header">
              	<h3 class="card-title" style="font-size: 1.00rem">Códigos GesCred habilitados</h3>
              	<div class="card-tools">
                		<input type="button" class="btn btn-default btn-sm float-right" id="agregar" value="Agregar código">
                	</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered big-table" id="table-codigos">
                  <thead>                  
                    <tr>
                      <th style="width: 15%">Código</th>
                      <th>DNI</th>
                      <th>Recibo hab</th>
                      <th>Fac. servicios</th>
                      <th>Mov. bancarios</th>
                      <th>Comp. CBU</th>
                      <th>Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@if ($valores!=null)
	                  	@foreach ($valores as $val)
	                  		<tr data-id="{{$fila}}">
		                      <td><input type="text" name="codigos[]" value="{{$val->codigo}}" class="form-control txt-code"></td>
		                      <td>
		                      	<select name="dni[]" class="form-control">
		                      		<option value="0" @if ($val->dni==0) selected @endif>No</option>
		                      		<option value="1" @if ($val->dni==1) selected @endif>Sí</option>
		                      	</select>
		                      </td>
		                      <td>
		                      	<select name="recibo_hab[]" class="form-control">
		                      		<option value="0" @if ($val->recibo_hab==0) selected @endif>No</option>
		                      		<option value="1" @if ($val->recibo_hab==1) selected @endif>Sí</option>
		                      	</select>
		                      </td>
		                      <td>
		                      	<select name="fac_servicios[]" class="form-control">
		                      		<option value="0" @if ($val->fac_servicios==0) selected @endif>No</option>
		                      		<option value="1" @if ($val->fac_servicios==1) selected @endif>Sí</option>
		                      	</select>
		                      </td>
		                      <td>
		                      	<select name="mov_bancarios[]" class="form-control">
		                      		<option value="0" @if ($val->mov_bancarios==0) selected @endif>No</option>
		                      		<option value="1" @if ($val->mov_bancarios==1) selected @endif>Sí</option>
		                      	</select>
		                      </td>
		                      <td>
		                      	<select name="comp_cbu[]" class="form-control">
		                      		<option value="0" @if ($val->comp_cbu==0) selected @endif>No</option>
		                      		<option value="1" @if ($val->comp_cbu==1) selected @endif>Sí</option>
		                      	</select>
		                      </td>
		                      <td align="center" style="vertical-align: middle"><a href="javascript:void(0)" onclick="eliminar_fila({{$fila}})"><i class="fas fa-trash-alt"></i></a></td>                  			
	                  		</tr>
	                  		<?php $fila++?>
	                  	@endforeach
                  	@endif
                  </tbody>
                </table>
              </div>


            </div>
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
			$('body').on('click', '#agregar', function() {
				ultimo_id = ($('#table-codigos tr:last').data('id') === undefined) ? 1 : $('#table-codigos tr:last').data('id') + 1;

				$('#table-codigos tbody').append('<tr data-id=\"' + ultimo_id + '\"><td><input type=\"text\" name=\"codigos[]\" class=\"form-control txt-code\"></td><td><select name=\"dni[]\" class=\"form-control\"><option value=\"0\" selected>No</option><option value=\"1\">Sí</option></select></td><td><select name=\"recibo_hab[]\" class=\"form-control\"><option value=\"0\" selected>No</option><option value=\"1\">Sí</option></select></td><td><select name=\"fac_servicios[]\" class=\"form-control\"><option value=\"0\" selected>No</option><option value=\"1\">Sí</option></select></td><td><select name=\"mov_bancarios[]\" class=\"form-control\"><option value=\"0\" selected>No</option><option value=\"1\">Sí</option></select></td><td><select name=\"comp_cbu[]\" class=\"form-control\"><option value=\"0\" selected>No</option><option value=\"1\">Sí</option></select></td><td align=\"center\" style=\"vertical-align: middle\"><a href="javascript:void(0)" onclick=\"eliminar_fila(' + ultimo_id + ')\"><i class=\"fas fa-trash-alt\"></i></a></td></tr>');    		
			});

			$('#frm').on('submit', function() {
				$('.content').find('.alert-success').first().remove();
				var inputs = $('.txt-code');
				input_vacio = false;
				$(inputs).each(function(){
				 var text_value=$(this).val();
			     if(text_value=='')
			       {
			        input_vacio = true;
			        }

			   })

				_errores = '';
		        if(input_vacio == true) {
		            _errores += '<li>Hay códigos vacíos</li>';
		        }

				if(_errores!='') {
					$('.content').find('.alert-danger').first().remove();
					$('.content').prepend('<ul class="alert alert-danger" style="list-style-type: none">' + _errores + '</ul>');
					return false;
				}
			
		    
			});

		});

		function eliminar_fila(fila){
			$('#table-codigos tr[data-id="'+fila+'"]').remove();
		}
	</script>
@endsection