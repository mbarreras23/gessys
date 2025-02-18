@extends('layouts.app')
@section('title', 'Proyectos')
@section('content')
    <x-page-title>Proyectos</x-page-title>
    <x-breadcrumb :links="[
        ['title' => 'Inicio', 'url' => route('welcome'), 'active' => false],
        ['title' => 'Proyectos', 'url' => route('projects.index'), 'active' => true],
    ]" />
    <div class="container">
        @include('alerts.alerts')
    </div>
    <div class="container">
        <div class="d-flex justify-content-end mb-1 me-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#store_project">
                <i class="fa fa-plus"></i> Nuevo
            </button>
        </div>
        <table class="table table-striped table-responsive shadow">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Conceptos</th>
                    <th>Costo</th>
                    <th>Etapas</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->initial_date }}</td>
                        <td>{{ $project->final_date }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">
                                <i class="fa fa-bars"></i>
                            </button>
                        </td>
                        <td>${{ number_format($project->cost, 2) }}</td>
                        <td>
                            <a href="{{ route('projects.stages', $project->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-step-forward"></i>
                            </a>
                        </td>
                        <td>
                            <span class="{{ $project->status->className() }}">
                                {{ $project->status->description() }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#update_project_{{ $project->id }}">
                                <i class="fa-solid fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#projects_destroy_{{ $project->id }}">
                                <i class="fa-solid fa fa-trash"></i>
                            </button>
                            @include('components.confirmation-modal', [
                                'modal_destroy_id' => 'projects_destroy_' . $project->id,
                                'route' => route('projects.destroy', $project->id),
                                'title' => '¿Desea eliminar el siguiente proyecto?',
                                'message' => $project->name,
                            ])
                            <a target="_blank" href="{{ route('projects.export_pdf', $project->id) }}"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="9">¡No hay coincidencias!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $projects->links() !!}
    </div>

    <!-- modals -->
    @include('components.save-modal', [
        'modal_save_id' => 'store_project',
        'modal_size' => 'modal-lg',
        'title' => 'Agregar nuevo proyecto',
        'action' => route('projects.store'),
        'method' => 'POST',
        'inputs' => [
            [
                'label' => 'Nombre',
                'class' => 'form-control',
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'Descripcion',
                'class' => 'form-control',
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'required' => false,
            ],
            [
                'label' => 'Inicio',
                'class' => 'form-control',
                'name' => 'initial_date',
                'id' => 'initial_date',
                'type' => 'date',
                'required' => true,
            ],
            [
                'label' => 'Fin',
                'class' => 'form-control',
                'name' => 'final_date',
                'id' => 'final_date',
                'type' => 'date',
                'required' => true,
            ],
        ],
    ])

    <script>
        let selectedConcepts = {};

        function updateDefaultCost() {
            let select = document.getElementById("concept_select");
            let costInput = document.getElementById("concept_cost");

            let selectedOption = select.options[select.selectedIndex];
            let defaultCost = selectedOption.getAttribute("data-cost");

            costInput.value = defaultCost;
        }

        function addConcept() {
            let select = document.getElementById("concept_select");
            let costInput = document.getElementById("concept_cost");
            let tableBody = document.getElementById("concept_table");

            let conceptId = select.value;
            let conceptName = select.options[select.selectedIndex].getAttribute("data-label");
            let conceptCost = parseFloat(costInput.value);

            if (conceptId === "" || isNaN(conceptCost)) {
                alert("Seleccione un concepto y especifique un costo válido.");
                return;
            }

            // Evitar duplicados
            if (selectedConcepts.hasOwnProperty(conceptId)) {
                alert("Este concepto ya ha sido agregado.");
                return;
            }

            // Agregar al objeto
            selectedConcepts[conceptId] = conceptCost;

            // Crear fila en la tabla
            let row = document.createElement("tr");
            row.setAttribute("data-id", conceptId);
            row.innerHTML = `
            <td>${conceptName}</td>
            <td>$${conceptCost.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeConcept('${conceptId}')"><i class="fa-solid fa fa-trash"></i></button>
            </td>
        `;

            tableBody.appendChild(row);

            updateHiddenField();

            select.value = "";
            costInput.value = "";
        }

        function removeConcept(conceptId) {
            delete selectedConcepts[conceptId];
            document.querySelector(`tr[data-id='${conceptId}']`).remove();

            updateHiddenField();
        }

        function updateHiddenField() {
            document.getElementById("concepts_input").value = JSON.stringify(selectedConcepts);
        }

        function filterConcepts() {
            let input = document.getElementById("concept_search").value.toLowerCase();
            let select = document.getElementById("concept_select");

            for (let i = 1; i < select.options.length; i++) {
                let option = select.options[i];
                let text = option.getAttribute("data-label").toLowerCase();

                option.style.display = text.includes(input) ? "" : "none";
            }
        }
    </script>
@endsection
