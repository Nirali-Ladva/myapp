<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->date('birth_date')->nullable();
        $table->integer('age')->nullable();
        $table->string('country')->nullable();
        $table->string('state')->nullable();
        $table->string('city')->nullable();
        $table->string('education')->nullable();
        $table->string('occupation')->nullable();
        $table->string('profile_image')->nullable();
        $table->json('residential_proofs')->nullable();
        $table->boolean('profile_completed')->default(0);
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'first_name',
            'last_name',
            'birth_date',
            'age',
            'country',
            'state',
            'city',
            'education',
            'occupation',
            'profile_image',
            'residential_proofs',
            'profile_completed'
        ]);
    });
}

};

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_admin','profile_completed','first_name','last_name','birth_date','age',
                'country','state','city','profile_image','residential_proofs','education','occupation'
            ]);
        });
    }
};
