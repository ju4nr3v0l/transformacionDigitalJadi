<div class="container">

    <div class="row">
        <div class="col-lg-12">

            @if(!empty($successMessage))
                <div class="alert alert-success">
                    {{ $successMessage }}
                </div>
            @endif

            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-circle {{ $currentStep != 0 ? 'btn-default' : 'btn-primary' }}">1</a>

                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-circle {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">2</a>

                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-circle {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">3</a>

                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" type="button" class="btn btn-circle {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">4</a>

                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-5" type="button" class="btn btn-circle {{ $currentStep != 4 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">5</a>
                    </div>
                </div>
            </div>

            <div class="row setup-content {{ $currentStep != 0 ? 'displayNone' : '' }}" id="step-0">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Objetivos de Transformación Digital</h3>
                        <p>
                            Bienvenido a la primera fase de nuestra encuesta DigiPT, donde comenzaremos a esclarecer el panorama de transformación digital de su organización. Sus respuestas serán fundamentales para identificar el rumbo que debemos tomar juntos en este viaje de evolución y adaptación tecnológica. Conozcamos sus aspiraciones, retos y experiencias anteriores para personalizar nuestro enfoque y asegurar que la transformación digital se traduzca en resultados concretos y beneficios duraderos para su empresa.

                        </p>
                        <p>
                            Por favor, complete el siguiente formulario con sus datos personales y profesionales. Posteriormente, responderá una serie de preguntas que nos permitirán evaluar su nivel de madurez digital en ocho dimensiones clave: Estrategia Digital, Tecnología y Arquitectura, Innovación, Agilidad Organizacional, Analítica y Datos, Operaciones y Procesos, Personas y Cultura, y Experiencia del Cliente.
                        </p>

                        <div class="form-group">
                            <label for="title">Nombre Completo:</label>
                            <input type="text" wire:model="nombreCompleto" class="form-control" id="nombreCompleto">
                            @error('nombreCompleto') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Correo:</label>
                            <input type="email" wire:model="correo" class="form-control" id="correo"/>
                            @error('correo') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Celular:</label>
                            <input type="number" wire:model="celular" class="form-control" id="taskDescription"/>
                            @error('celular') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Nit:</label>
                            <input type="text" wire:model="nit" class="form-control" id="nit"/>
                            @error('nit') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Nombre Inmobiliaria:</label>
                            <input type="text" wire:model="nombreInmobiliaria" class="form-control" id="nombreInmobiliaria">
                            @error('nombreInmobiliaria') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Cargo:</label>
                            <input type="text" wire:model="cargo" class="form-control" id="cargo">
                            @error('cargo') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Cargo:</label>
                            <input type="text" wire:model="cargo" class="form-control" id="cargo">
                            @error('cargo') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">¿Cuáles son los objetivos específicos de transformación digital de su organización y cómo se imagina que será la empresa una vez estos objetivos se hayan cumplido?
                                </label>
                            <textarea  wire:model="preInicio1" class="form-control" id="preInicio1"></textarea>
                            @error('preInicio1') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">La transformación digital implica cambios significativos y no exentos de desafíos. ¿Qué limitaciones o riesgos ha identificado en el proceso de transformación digital de su organización? Describa esos elementos que podrían representar un obstáculo para alcanzar sus metas.
                            </label>
                            <textarea  wire:model="preInicio2" class="form-control" id="preInicio2"></textarea>
                            @error('preInicio2') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Basándonos en el conocimiento que proviene de la experiencia, cuéntenos sobre sus iniciativas pasadas de transformación digital: ¿Qué acciones han emprendido? ¿Qué estrategias han resultado exitosas y cuáles no han tenido el impacto esperado?
                            </label>
                            <textarea  wire:model="preInicio3" class="form-control" id="preInicio3"></textarea>
                            @error('preInicio3') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <button class="btn btn-primary nextBtn btn-lg pull-right btn-form" wire:click="ceroStepSubmit" type="button" >Continuar</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-2">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Paso 2</h3>
                        @foreach($pregunta1 as $pregunta)
                            <div class="form-group">
                                <label for="title" class="question-head">{{ $pregunta->texto }}</label>
                                @error('respuesta'.$pregunta->preguntaId) <span class="error">{{ $message }}</span> @enderror
                                @foreach($pregunta->RespuestasPreguntas as $respuestas)
                                    <div class="form-check">
                                        <input class="form-check-input" name="respuesta{{$pregunta->preguntaId}}" type="radio" wire:model="respuesta{{$pregunta->preguntaId}}" value="{{ $respuestas->respuestaId }}" id="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                        <label class="form-check-label" for="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                            {{$respuestas->texto}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach
                        <button class="btn btn-primary nextBtn btn-lg pull-right btn-form" type="button" wire:click="unoStepSubmit">Siguiente</button>
                        <button class="btn btn-danger nextBtn btn-lg pull-right btn-form" type="button" wire:click="back(0)">Atras</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-3">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Paso 3</h3>
                        @foreach($pregunta2 as $pregunta)
                            <div class="form-group">
                                <label for="title" class="question-head">{{ $pregunta->texto }}</label>
                                @error('respuesta'.$pregunta->preguntaId) <span class="error">{{ $message }}</span> @enderror
                                @foreach($pregunta->RespuestasPreguntas as $respuestas)
                                    <div class="form-check">
                                        <input class="form-check-input" name="respuesta{{$pregunta->preguntaId}}" type="radio" wire:model="respuesta{{$pregunta->preguntaId}}" value="{{ $respuestas->respuestaId }}" id="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                        <label class="form-check-label" for="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                            {{$respuestas->texto}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="dosStepSubmit">Siguiente</button>
                        <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(1)">Atras</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-4">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Paso 4</h3>
                        @foreach($pregunta3 as $pregunta)
                            <div class="form-group">
                                <label for="title" class="question-head">{{ $pregunta->texto }}</label>
                                @error('respuesta'.$pregunta->preguntaId) <span class="error">{{ $message }}</span> @enderror
                                @foreach($pregunta->RespuestasPreguntas as $respuestas)
                                    <div class="form-check">
                                        <input class="form-check-input" name="respuesta{{$pregunta->preguntaId}}" type="radio" wire:model="respuesta{{$pregunta->preguntaId}}" value="{{ $respuestas->respuestaId }}" id="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                        <label class="form-check-label" for="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                            {{$respuestas->texto}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="tresStepSubmit">Siguiente</button>
                        <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(2)">Atras</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content {{ $currentStep != 4 ? 'displayNone' : '' }}" id="step-5">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Paso 5</h3>
                        @foreach($pregunta4 as $pregunta)
                            <div class="form-group">
                                <label for="title" class="question-head">{{ $pregunta->texto }}</label>
                                @error('respuesta'.$pregunta->preguntaId) <span class="error">{{ $message }}</span> @enderror
                                @foreach($pregunta->RespuestasPreguntas as $respuestas)
                                    <div class="form-check">
                                        <input class="form-check-input" name="respuesta{{$pregunta->preguntaId}}" type="radio" wire:model="respuesta{{$pregunta->preguntaId}}" value="{{ $respuestas->respuestaId }}" id="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                        <label class="form-check-label" for="respuestasPregunta.{{ $respuestas->respuestaId }}">
                                            {{$respuestas->texto}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="cuatroStepSubmit">Siguiente</button>
                        <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(3)">Atras</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content {{ $currentStep != 5 ? 'displayNone' : '' }}" id="step-6">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3>Felicitaciones, ya esta un paso más cerca de avanzar en la transformación digital para su empresa.</h3>

                        <div class="Title">
                            <h3>Gracias por completar la información</h3>
                            <p>Pronto recibira al correo electronico registrado toda la información para que su empresa despegue en la era digital 4.0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
