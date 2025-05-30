

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Vehiculos</title>
</head>
<body>
    <h1>Listado de móviles de ccv </h1>
    <form action="{{ route('vehiculos.store') }}" method="post">
        @csrf
        <table>
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
                <tr>
                    <td><input type="text" name="vehiculo_id"></td>
                    <td><input type="text" name="nombre" id=""></td>
                    <td><input type="text" name="matricula"></td>
                    <td><input type="text" name="km_real"></td>
                    <td><input type="text" name="km_recorridos"></td>
                    <td><button type="submit">Enviar</button></td>
                </tr>
                
            </tbody>
        </table>
    </form>
</body>
</html>