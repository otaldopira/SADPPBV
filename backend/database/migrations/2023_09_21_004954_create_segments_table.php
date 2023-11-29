<?php

use App\Models\Point;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id('segmento_id');
            $table->foreignId('ponto_inicial')
                ->constrained('points', 'ponto_id');
            $table->foreignId('ponto_final')
                ->constrained('points', 'ponto_id');
            $table->decimal('distancia', 8, 2);
            $table->string('direcao');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
