<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGroupListTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('group_no')->index()->comment('群聊编号');
            $table->bigInteger('owner_user_id')->comment('群主user_id');
            $table->integer('type')->default('1')->comment('群聊类型, 1 普通群，2 vip群');
            $table->string('name')->comment('群聊名称');
            $table->string('avatar')->nullable()->comment('群组头像');
            $table->string('describe')->nullable()->comment('描述');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_list');
    }
}
