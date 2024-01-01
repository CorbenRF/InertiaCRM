<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *Schema::create('entries', function (Blueprint $table) {
            *$table->id()->autoIncrement()->from(1);
            *$table->string('client_entry_num');
            *$table->date('date_received');
            *$table->date('date_startby');
            *$table->date('date_actual_start')->nullable();
            *$table->date('date_end')->nullable();
            *$table->foreignId('department_id')->nullable()->constrained(table: 'departments', indexName: 'id');
            *$table->foreignId('client_name_id')->nullable()->constrained(table: 'clients', indexName: 'id');
            *$table->foreignId('vendor_name_id')->nullable()->constrained(table: 'vendors', indexName: 'id');
            *$table->foreignId('subvendor_name_id')->nullable()->constrained(table: 'subvendors', indexName: 'id');
            *$table->foreignId('status_id')->nullable()->constrained(table: 'statuses', indexName: 'id');
            *$table->foreignId('curator_id')->nullable()->constrained(table: 'curators', indexName: 'id');
            *$table->foreignId('inspector_id')->nullable()->constrained(table: 'inspectors', indexName: 'id');
            *$table->boolean('expired')->default(0);
            *$table->boolean('busy_edit')->default(0);
            *$table->json('comments');
            *$table->timestamp('updated_at')->useCurrentOnUpdate();
            *$table->timestamp('created_at')->useCurrent();
            *$table->enum('inspection_lvl', ['1', '2', '3']);
        });
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id()->autoIncrement()->from(1);
            $table->string('client_entry_num');
            $table->date('date_received');
            $table->date('date_startby');
            $table->date('date_actual_start')->nullable();
            $table->date('date_end')->nullable();
            $table->unsignedBigInteger('department_id')->nullable()->default(1); // added defaults, havent tested them out of the box
            $table->unsignedBigInteger('client_name_id')->nullable()->default(1);
            $table->unsignedBigInteger('vendor_name_id')->nullable()->default(1);
            $table->unsignedBigInteger('subvendor_name_id')->nullable()->default(1);
            $table->unsignedBigInteger('status_id')->nullable()->default(1);
            $table->unsignedBigInteger('curator_id')->nullable()->default(1);
            $table->unsignedBigInteger('inspector_id')->nullable()->default(1);
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('client_name_id')->references('id')->on('clients');
            $table->foreign('vendor_name_id')->references('id')->on('vendors');
            $table->foreign('subvendor_name_id')->references('id')->on('subvendors');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('curator_id')->references('id')->on('curators');
            $table->foreign('inspector_id')->references('id')->on('inspectors');
            $table->boolean('expired')->default(0);
            $table->boolean('busy_edit')->default(0);
            $table->json('comments');
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrent();
            $table->enum('inspection_lvl', ['1', '2', '3']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
