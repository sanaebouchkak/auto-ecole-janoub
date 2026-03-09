<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('resultat_examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidat_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // code, conduite
            $table->string('resultat'); // favorable, defavorable
            $table->date('date_examen');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('resultat_examens');
    }
};
