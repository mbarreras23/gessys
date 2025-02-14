<?php

namespace App\Models;

use App\Enums\StatusProjectEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "project_id",
        "name",
        "description",
        "initial_date",
        "final_date",
        "cost",
        "status"
    ];

    protected $hidden = [
        "deleted_at"
    ];

    protected $casts = [
        "status" => StatusProjectEnum::class
    ];

    // Relationships

    /**
     * Get the project that owns the ProjectStage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
