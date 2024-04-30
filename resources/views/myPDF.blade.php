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
    <img style="width: 100%; height: 70%;"  src="https://quickchart.io/chart?c={type:'radar',data:{labels:[{{$data['graficos']['dimensiones']}}],datasets:[{label:'Valores',data:[{{$data['graficos']['valores']}}]}]},options:{legend:{display:true,position:'right',align:'start'},scale:{ticks:{suggestedMin: 0,suggestedMax: 3,stepSize: 1,showLabelBackdrop: true}}}}"/>
    <div>
        <div class="page-break"></div>
    </div>
    <h1 class="display-4" style="text-align: center">Resumen Ejecutivo</h1>
    <p class="lead">{!! nl2br(e($data['resumenes']['resumen_ejecutivo'])) !!}</p>
    <div class="page-break"></div>
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
            <h1 class="display-5">Diagnóstico y Recomendaciones</h1>
            @if(isset($dimension['recomendacion']->TituloDimension))
                <p class="lead">{!! nl2br(e($dimension['recomendacion']->TituloDimension))!!}</p>
                <p class="lead">{!! nl2br(e($dimension['recomendacion']->ParrafoDimension))!!}</p>
                @php $incr = 1;@endphp
                @foreach($dimension['recomendacion']->Recomendaciones as $recomendacion)

                        <span>- </span><p class="lead">{!! nl2br(e($recomendacion))!!}</p>
                    @php$incr++;@endphp
                @endforeach

            @endif
            <div class="page-break"></div>
        @endforeach

</div>
</body>
</html>
