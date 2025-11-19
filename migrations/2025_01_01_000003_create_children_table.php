<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up()
{
    Schema::create('children', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // who added
        $table->string('first_name');
        $table->string('last_name')->nullable();
        $table->string('email')->nullable();
        $table->string('country')->nullable();
        $table->date('birth_date')->nullable();
        $table->integer('age')->nullable();
        $table->string('state')->nullable();
        $table->string('city')->nullable();
        $table->json('documents')->nullable(); // birth certificate
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('children');
    }
};
