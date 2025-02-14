<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectStageRequest;
use App\Models\Concept;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Route;

#[Prefix("projects")]
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[Route("GET", "/", "projects.index")]
    public function index()
    {
        return view("projects.index", [
            "projects" => Project::with("concepts")->paginate(20)->withQueryString(),
            "concepts" => Concept::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Route("POST", "/", "projects.store", middleware: "json-decode:concepts")]
    public function store(ProjectRequest $request)
    {
        try {
            DB::beginTransaction();

            $project = Project::create($request->validated());

            if ($request->concepts) {
                foreach ($request->concepts as $concept_id => $price) {
                    $project->attachConcept($concept_id, $price);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();

            return back()->with("alert-danger", $th->getMessage());
        }

        DB::commit();

        return back()->with("alert-success", "Nuevo pryecto creado: " . $project->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Route("DELETE", "/{project}", "projects.destroy")]
    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with("alert-danger", "¡Proyecto eliminado!");
    }

    #[Route("GET", "/{project}/stages", "projects.stages")]
    public function projectStages(Project $project)
    {
        return view("projects.project-stages", [
            "project" => $project->load("stages")
        ]);
    }

    #[Route("POST", "/{project}/stages", "projects.stages.store")]
    public function projectStagesStore(Project $project, ProjectStageRequest $request)
    {
        $stage = $project->stages()->create($request->validated());

        return back()->with("alert-success", "Etapa creada: $stage->name");
    }
}
