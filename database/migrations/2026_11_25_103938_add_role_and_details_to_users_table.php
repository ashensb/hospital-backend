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
        Schema::table('users', function (Blueprint $table) {
            //add new column
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->enum('role', ['patient', 'doctor', 'nurse', 'admin'])->default('patient')->after('password');
            $table->string('phone')->nullable()->after('role');
            $table->string('staff_id')->nullable()->after('phone'); // Doctors/Nurses/Admin 
            $table->string('license_no')->nullable()->after('staff_id'); // Doctor/Nurse
            $table->string('employee_id')->nullable()->after('license_no'); // Staff 
            
            // Drop the 'name' column
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the newly added columns
            $table->dropColumn(['first_name', 'last_name', 'role', 'phone', 'staff_id', 'license_no', 'employee_id']);
            
            // Add back the 'name' column
            $table->string('name')->after('id');
        });
    }
};