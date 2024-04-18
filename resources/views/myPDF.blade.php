<!DOCTYPE html>
<html>
<head>
    <title>Testeo Reporte Consultoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
</head>
<body>
<h1>Resultados Consultoria</h1>




    @foreach($data as $dimension)
        @foreach($dimension as $capacidad)
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>{{ $capacidad['dimension'] }}</h2>
                    </div>

                    <div class="col-md-6">
                        <h3>{{ $capacidad['capacidad'] }}</h3>
                    </div>

                    <div class="col-md-6">
                        <h4>{{ $capacidad['pregunta'] }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>{{ $capacidad['respuesta'] }}</h4><p>{{$capacidad['valor']}}</p><p>{{$capacidad['clasificacion']}}</p>
                    </div>
                    <div class="col-md-12">
                        <p>{{ $capacidad['recomendacion'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach


</body>
</html>
