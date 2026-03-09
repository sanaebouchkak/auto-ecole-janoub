<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moniteur_id')->constrained()->cascadeOnDelete();
            $table->foreignId('formation_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('statut')->default('disponible'); // disponible, reservee, terminee
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('seances');
    }
};
