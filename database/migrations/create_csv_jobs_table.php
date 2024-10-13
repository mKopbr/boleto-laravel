<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvJobsTable extends Migration
{
    /**
     * Executa a migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique();
            $table->integer('processed_chunks')->default(0);
            $table->integer('total_chunks')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverte a migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_jobs');
    }
}