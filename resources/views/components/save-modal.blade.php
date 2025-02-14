<!-- componente modal -->
<div class="modal fade" id="{{ $modal_save_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog {{ $modal_size ?? '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @php
                $hasFile = collect($inputs)->contains(fn($input) => $input['type'] === 'file');
            @endphp

            <form class="mb-0" action="{{ $action }}" method="POST"
                @if ($hasFile) enctype="multipart/form-data" @endif>

                @csrf
                @method($method)

                <div class="modal-body">
                    <div class="row">
                        @foreach ($inputs as $input)
                            <div class="form-group mb-3">
                                <label for="{{ $input['name'] }}"
                                    class="form-label"><b>{{ $input['label'] }}</b></label>

                                @switch($input['type'])
                                    @case('select')
                                        <select class="{{ $input['class'] ?? '' }}" name="{{ $input['name'] }}"
                                            id="{{ $input['id'] }}" @isset($input['required']) required @endisset>

                                            @foreach ($input['options'] as $item)
                                                <option value="{{ $item->value }}"
                                                    @if (isset($input['value']) && $input['value'] == $item->value) selected @endif>
                                                    {{ $item->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @break

                                    @case('textarea')
                                        <textarea class="{{ $input['class'] ?? '' }}" id="{{ $input['id'] }}" name="{{ $input['name'] }}"
                                            rows="{{ $input['rows'] ?? 5 }}" @isset($input['required']) required @endisset>{{ $input['value'] ?? '' }}</textarea>
                                    @break

                                    @case('checkbox')
                                    @case('radio')
                                        <div class="form-check">
                                            <input class="form-check-input {{ $input['class'] ?? '' }}"
                                                type="{{ $input['type'] }}" id="{{ $input['id'] }}"
                                                name="{{ $input['name'] }}" value="{{ $input['value'] ?? '' }}"
                                                @isset($input['checked']) checked @endisset>
                                            <label class="form-check-label" for="{{ $input['id'] }}">
                                                {{ $input['label'] }}
                                            </label>
                                        </div>
                                    @break

                                    @default
                                        <input @isset($input['step']) step="{{ $input['step'] }}" @endisset
                                            class="{{ $input['class'] ?? '' }}" type="{{ $input['type'] }}"
                                            id="{{ $input['id'] }}" name="{{ $input['name'] }}"
                                            value="{{ $input['value'] ?? '' }}"
                                            @isset($input['required']) required @endisset
                                            placeholder="Ingrese {{ $input['label'] ?? '' }}">
                                @endswitch
                            </div>
                        @endforeach
                    </div>

                    <!-- Conceptos -->
                    @isset($concepts)
                        <div class="mt-3">
                            <label for="concept_search" class="form-label"><b>Agregar conceptos</b></label>

                            <div class="input-group mb-3">
                                <!-- Input de búsqueda -->
                                <input type="text" id="concept_search" class="form-control"
                                    placeholder="Escriba para buscar..." onkeyup="filterConcepts()">
                                <!-- Select con conceptos -->
                                <select id="concept_select" class="form-select" onchange="updateDefaultCost()">
                                    <option value="">Seleccione un concepto</option>
                                    @foreach ($concepts as $concept)
                                        <option value="{{ $concept->id }}" data-label="{{ $concept->name }}"
                                            data-cost="{{ $concept->price }}">
                                            {{ $concept->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Input de costo -->
                                <input type="number" id="concept_cost" class="form-control" placeholder="Costo"
                                    min="0" step="any">

                                <!-- Botón para agregar -->
                                <button type="button" class="btn btn-primary" onclick="addConcept()">Agregar</button>
                            </div>

                            <!-- Tabla de conceptos agregados -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Costo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="concept_table"></tbody>
                            </table>

                            <!-- Campo oculto para enviar conceptos al backend -->
                            <input type="hidden" name="concepts" id="concepts_input">
                        </div>
                    @endisset

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa fa-times"></i> Cerrar
                    </button>
                    <button type="submit" class="btn btn-{{ $method === 'POST' ? 'primary' : 'warning' }}">
                        <i class="fa fa-save"></i> {{ $method === 'POST' ? 'Guardar' : 'Editar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
