<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('chat_no', 16)->unique()->comment('微聊号');
            $table->string('avatar')->default('')->comment('头像');
            $table->unsignedTinyInteger('sex')->default(0)->comment('性别 0男 1女');
            $table->string('signature')->default('')->comment('个性签名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['chat_no', 'avatar', 'sex', 'signature']);
        });
    }
}
