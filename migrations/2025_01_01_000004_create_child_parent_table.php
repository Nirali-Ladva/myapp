<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up()
{
    Schema::create('child_parent', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('parent_id');
        $table->unsignedBigInteger('child_id');
        $table->timestamps();

        $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
        $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('child_parent');
    }
};
