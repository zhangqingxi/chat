<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
            $table->unsignedInteger('friend_id')->default(0)->comment('好友id');
            $table->string('content')->default('')->comment('聊天内容');
            $table->unsignedTinyInteger('content_type')->default(0)->comment('内容类型 0文本 1语音 2图片 3视频 4表情');
            $table->unsignedTinyInteger('is_read')->default(0)->comment('是否已读 0未读 1已读');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_chat_messages');
    }
}
