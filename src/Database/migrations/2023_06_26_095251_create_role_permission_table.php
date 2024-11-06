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
        Schema::create(config('hi_permissions.role_permission_table', 'role_permission'), function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('role_id')->references('id')->on(config('hi_permissions.roles_table', 'roles'))->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on(config('hi_permissions.permissions_table', 'permissions'))->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['role_id','permission_id']);
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('hi_permissions.role_permission_table', 'role_permission'));
    }
};
