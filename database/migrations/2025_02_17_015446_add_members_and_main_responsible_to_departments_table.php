<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMembersAndMainResponsibleToDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->json('members')->nullable();
            $table->unsignedBigInteger('main_responsible')->nullable();
            
            // Thêm khóa ngoại nếu bảng nhân viên (users) có tồn tại
            $table->foreign('main_responsible')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('members');
            $table->dropForeign(['main_responsible']);
            $table->dropColumn('main_responsible');
        });
    }
}
