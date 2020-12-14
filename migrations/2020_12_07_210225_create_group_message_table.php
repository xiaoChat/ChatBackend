<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGroupMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('msg_type')->default('1')->comment('消息类型，1普通内容，2图片，3视频，4 友链');
            $table->bigInteger('user_id')->index();
            $table->string('group_id')->index();
            $table->text('context')->comment('消息内容');
            $table->timestamp('send_time')->comment('发送时间');
            $table->tinyInteger('is_read')->default(0)->comment('是否查看，0未查看，1已读');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_message');
    }
}
