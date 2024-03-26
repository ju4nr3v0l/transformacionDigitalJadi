<div>

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
            <div class="stepwizard-step">
                <a href="#step-6" type="button" class="btn btn-circle {{ $currentStep != 5 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">6</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-7" type="button" class="btn btn-circle {{ $currentStep != 6 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">7</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-8" type="button" class="btn btn-circle {{ $currentStep != 7 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">8</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-9" type="button" class="btn btn-circle {{ $currentStep != 8 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">9</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-10" type="button" class="btn btn-circle {{ $currentStep != 9 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">10</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-11" type="button" class="btn btn-circle {{ $currentStep != 10 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">11</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-12" type="button" class="btn btn-circle {{ $currentStep != 11 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">12</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-13" type="button" class="btn btn-circle {{ $currentStep != 12 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">13</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-14" type="button" class="btn btn-circle {{ $currentStep != 13 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">14</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-15" type="button" class="btn btn-circle {{ $currentStep != 14 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">15</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-16" type="button" class="btn btn-circle {{ $currentStep != 15 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">16</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-17" type="button" class="btn btn-circle {{ $currentStep != 16 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">17</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-18" type="button" class="btn btn-circle {{ $currentStep != 17 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">18</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-19" type="button" class="btn btn-circle {{ $currentStep != 18 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">19</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-20" type="button" class="btn btn-circle {{ $currentStep != 19 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">20</a>

            </div>
            <div class="stepwizard-step">
                <a href="#step-21" type="button" class="btn btn-circle {{ $currentStep != 20 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">21</a>
               
            </div>
        </div>
    </div>

    <div class="row setup-content {{ $currentStep != 0 ? 'displayNone' : '' }}" id="step-0">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Paso 1</h3>

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
                    <input type="number" wire:model="celular" class="form-control" id="taskDescription">{{{ $celular ?? '' }}}</input>
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

                <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="ceroStepSubmit" type="button" >Continuar</button>
            </div>
        </div>
    </div>
    <div class="row setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Paso 2</h3>

                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="unoStepSubmit">Siguiente</button>
                <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(0)">Atras</button>
            </div>
        </div>
    </div>
    <div class="row setup-content {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Step 3</h3>


                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="dosStepSubmit">Siguiente</button>
                <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(1)">Atras</button>
            </div>
        </div>
    </div>
    <div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Step 3</h3>


                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="tresStepSubmit">Siguiente</button>
                <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(2)">Atras</button>
            </div>
        </div>
    </div>

</div>
