<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->date('date_inscription')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('candidats');
    }
};
