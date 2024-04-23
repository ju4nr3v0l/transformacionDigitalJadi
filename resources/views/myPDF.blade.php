<!DOCTYPE html>
<html>
<head>
    <title>Testeo Reporte Consultoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<blockquote class="row">
    <h1 class="display-3">Resultados Consultoria</h1>
    @foreach($data as $dimension)
        <h1 class="display-4">{{ $dimension['nombre'] }}</h1>
        <h1 class="display-6">Diagnóstico y Recomendaciones</h1>
        <p class="lead">{!! nl2br(e($dimension['recomendacion']))!!}</p>
        <p>Promt usado: {!! nl2br(e($dimension['promt']))!!}</p>
        @foreach($dimension as $capacidad)
            @if(isset($capacidad['capacidad']))
                <h1 class="display-6"> Preguntas y respuestas </h1>
                <blockquote class="blockquote">
                    <p>{{ $capacidad['capacidad'] }}</p>
                </blockquote>
            @endif
            @if(isset($capacidad['descripcion_capacidad']))
                <div class="col-md-6">
                    <p class="lead">{{ $capacidad['descripcion_capacidad'] }}</p>
                </div>
            @endif
            @if(isset($capacidad['pregunta']))
                <blockquote class="blockquote">
                    <p class="lead">{{ $capacidad['pregunta'] }}</p>
                </blockquote>
            @endif
            <div class="col-md-6">
                @if(isset($capacidad['respuesta']))
                    <figure>
                        <figcaption class="blockquote-footer">
                            <p>{{ $capacidad['respuesta'] }}</p>
                        </figcaption>
                    </figure>
                @endif
                @if(isset($capacidad['valor']))
                    <p class="lead">Valor: {{$capacidad['valor']}}</p>
                @endif
                @if(isset($capacidad['clasificacion']))
                    <p class="lead">Clasificación: {{$capacidad['clasificacion']}}</p>
                @endif
            </div>


</div>
        @endforeach
    @endforeach


</body>
</html>
