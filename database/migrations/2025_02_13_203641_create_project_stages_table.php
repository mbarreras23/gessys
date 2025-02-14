<?php

use App\Enums\StatusProjectEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->constrained();
            $table->string("name");
            $table->text("description")->nullable();
            $table->date("initial_date")->nullable();
            $table->date("final_date")->nullable();
            $table->decimal("cost", 18);
            $table->enum("status", StatusProjectEnum::values())->default(StatusProjectEnum::WAITING);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_stages');
    }
};
