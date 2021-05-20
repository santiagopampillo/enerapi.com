<table class="table">
    <tbody>
            <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Habilitada</th>
            </tr>
            @foreach($registros as $registro)
            <tr>
                   
                <td>{!! $registro->codigo !!}</td>
                <td>{!! $registro->nombre !!}</td>
                <td>{!! $registro->estado == 1 ? '<i class="fas fa-check" style="color:green"></i>' : '<i class="fas fa-times"  style="color:red"></i>' !!}</td>
            </tr>
            @endforeach
    </tbody>
</table>
