<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	public function up(): void
	{
		Schema::create('options', function(Blueprint $table) {
			$table->id();
			$table->string('option_name')->unique()->index();
			$table->string('batch_name')->nullable();
			$table->longText('option_value')->nullable();
			$table->string('option_type')->default('string'); // string, json, array, boolean, integer, float
			$table->text('description')->nullable();
			$table->integer('position')->default(0)->index();
			$table->boolean('is_autoload')->default(false)->index();
			$table->boolean('is_system')->default(false);
			$table->timestamps();
			
			$table->index(['option_name', 'is_autoload']);
			$table->index('batch_name');
			$table->index(['batch_name', 'is_autoload']);
			$table->index(['batch_name', 'position']);
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('options');
	}
};
