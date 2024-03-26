<div>

    @foreach ($dimensiones as $dimension)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $dimension->nombre }}</h1>
                    @foreach ($dimension->capacidades as $capacidad)
                        <h2>{{ $capacidad->nombre }}</h2>
                        <p>{{ $capacidad->descripcion }}</p>
                    @endforeach
                </div>
            </div>
        </div>

@endforeach
