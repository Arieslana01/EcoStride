<?php

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
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        $table->string('title');

        $table->enum('category', [
            'Tennis',
            'Table Tennis',
            'Padel',
            'Mini Soccer',
            'Yoga',
            'Pilates'
        ]);

        $table->text('description')->nullable();

        $table->date('event_date');
        $table->time('event_time');

        $table->string('location');

        $table->integer('quota')->default(20);

        $table->integer('points')->default(50);

        $table->enum('status', [
            'Open',
            'Closed',
            'Completed'
        ])->default('Open');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
