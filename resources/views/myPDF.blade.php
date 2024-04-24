<!DOCTYPE html>
<html>
<head>
    <title>Testeo Reporte Consultoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>

</head>
<body>
<div class="row">
    <h1 class="display-3" style="text-align: center">Resultados Consultoria</h1>
    <br/>
    <br/>
    <br/>
    <img style="width: 100%; height: 50%;"  src="https://quickchart.io/chart?c={type:'radar',data:{labels:[{{$data['graficos']['dimensiones']}}],datasets:[{label:'Valores',data:[{{$data['graficos']['valores']}}]}]}}"/>
    <div>
        <div class="page-break"></div>
    </div>

        @foreach($data as $dimension)
            @if(isset($dimension['nombre']))
                <h1 class="display-4">{{ $dimension['nombre'] }}</h1>
            @else
                @continue($data)
            @endif
            @if(isset($dimension['promedio']))
                <p class="lead">Valor: {{ $dimension['promedio'] }}<p>
            @endif
            @if(isset($dimension['Clasificacion']))
                <p class="lead">Estado: {{ $dimension['Clasificacion'] }}<p>
            @endif
            @if(isset($dimension['nombre']))
                <h1 class="display-5"> Capacidades evaluadas de la dimensión {{ $dimension['nombre'] }}</h1>
            @endif
                @foreach($dimension as $capacidad)

                    @if(isset($capacidad['capacidad']))
                        <p class="lead">{{ $capacidad['capacidad'] }}</p>

                    @endif
                    @if(isset($capacidad['descripcion_capacidad']))
                        <div class="col-md-6">
                            <blockquote class="blockquote">
                                <p >{{ $capacidad['descripcion_capacidad'] }}</p>
                            </blockquote>
                        </div>
                    @endif
                @endforeach
            <h1 class="display-5">Diagnóstico y Recomendaciones</h1>
            @if(isset($dimension['recomendacion']))
                <p class="lead">{!! nl2br(e($dimension['recomendacion']))!!}</p>
            @endif
            <div class="page-break"></div>
        @endforeach

</div>
</body>
</html>
