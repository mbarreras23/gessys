<?php

namespace App\Models;

use App\Enums\StatusProjectEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use PDF;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "initial_date",
        "final_date",
        "status"
    ];

    protected $casts = [
        "status" => StatusProjectEnum::class
    ];

    protected $appends = [
        "cost"
    ];

    // Accessors - Appends - Mutators

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn () => $this->concepts()->sum("concept_project.price")
        );
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucfirst($value)
        );
    }

    // Relationships
    
    /**
     * Get all of the stages for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stages(): HasMany
    {
        return $this->hasMany(ProjectStage::class);
    }

    /**
     * The concepts that belong to the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class)
            ->withPivot('price')
            ->withTimestamps();
    }

    // Functions

    public function attachConcept(int $concept_id, float $price = 0)
    {
        $this->concepts()->attach([$concept_id => ["price" => $price]]);
    }

    public function getPdf(string $export_type = "stream")
    {
        $pdf = PDF::loadView("pdfs.project", [
            "project" => $this->load("concepts")
        ]);

        return match ($export_type) {
            default => $pdf->stream(Str::slug($this->name) . ".pdf"),
        };
    }
}
