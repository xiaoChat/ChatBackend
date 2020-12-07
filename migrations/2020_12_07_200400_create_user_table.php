<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chat_no')->index()->comment('唯一标识');
            $table->string('username')->index();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('nickname')->nullable();
            $table->tinyInteger('user_state_id')->default(0)->comment('用户当前状态：0离线，1在线，2隐身');
            $table->string('profile_id');
            $table->tinyInteger('status')->default(1)->comment('用户状态：1正常，0冻结');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
