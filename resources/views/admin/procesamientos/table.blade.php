<table class="table">
    <tbody>
            <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                <th>Codigo</th>
                <th>Año</th>
                <th>Mes</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
            @foreach($registros as $registro)
            <tr>
                <td>{!! $registro->codigo !!}</td>
                <td>{!! $registro->anio !!}</td>
                <td>{!! $registro->mes !!}</td>
                <td>{!! $registro->fecha !!}</td>
                <td>{!! $registro->estado !!}</td>
            </tr>
            @endforeach
    </tbody>
</table>
