<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Listado de móviles de ccv </h1>
        @csrf
        <table border="1">
            <thead>
                <tr>
                    <th>Vehiculo ID</th> 
                    <th>Nombre</th>
                    <th>Matricula</th>
                    <th>Km Real</th>
                    <th>Km Recorrido</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->vehiculo_id }}</td>
                        <td>{{ $vehiculo->nombre }}</td>
                        <td>{{ $vehiculo->matricula }}</td>
                        <td>{{ $vehiculo->km_real }}</td>
                        <td>{{ $vehiculo->km_recorridos }}</td>
                    </tr>
                @endforeach                
            </tbody>
        </table>
        <a href="{{ route('vehiculos.create') }}">Agregar Vehiculo</a>
</body>
</html>