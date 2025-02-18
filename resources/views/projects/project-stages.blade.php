@extends('layouts.app')
@section('title', 'Etapas del proyecto')
@section('content')
    <x-page-title>Fases - {{ $project->name }}</x-page-title>
    <x-breadcrumb :links="[
        ['title' => 'Inicio', 'url' => route('welcome'), 'active' => false],
        ['title' => 'Proyectos', 'url' => route('projects.index'), 'active' => false],
        ['title' => $project->name, 'url' => '', 'active' => true],
    ]" />
    <div class="container">
        @include('alerts.alerts')
    </div>
    <div class="container">
        <div class="d-flex justify-content-end mb-1 me-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#store_stage">
                <i class="fa fa-plus"></i> Nuevo
            </button>
        </div>
        <table class="table table-striped responsive shadow">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Costo</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($project->stages as $stage)
                    <tr>
                        <td>{{ $stage->id }}</td>
                        <td>{{ $stage->name }}</td>
                        <td>{{ $stage->initial_date }}</td>
                        <td>{{ $stage->final_date }}</td>
                        <td>${{ number_format($stage->cost, 2) }}</td>
                        <td>
                            <span class="{{ $project->status->className() }}">
                                {{ $project->status->description() }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#update_project_{{ $stage->id }}">
                                <i class="fa-solid fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#project_stages_destroy_{{ $stage->id }}">
                                <i class="fa-solid fa fa-trash"></i>
                            </button>
                            @include('components.confirmation-modal', [
                                'modal_destroy_id' => 'project_stages_destroy_' . $stage->id,
                                'route' => route('project_stages.destroy', $stage->id),
                                'title' => '¿Desea eliminar el siguiente proyecto?',
                                'message' => $stage->name,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="7">¡No hay coincidencias</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- modals -->
    @include('components.save-modal', [
        'modal_save_id' => 'store_stage',
        'title' => 'Agregar nueva etapa',
        'action' => route('projects.stages.store', $project->id),
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
            [
                'label' => 'Costo',
                'class' => 'form-control',
                'name' => 'cost',
                'id' => 'cost',
                'type' => 'number',
                'required' => true,
                'step' => 'any',
            ],
        ],
    ])
@endsection
