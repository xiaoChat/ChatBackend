<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->tinyInteger('sex')->default('0')->comment('性别: 0未设置，1 男，2 女');
            $table->integer('age')->nullable()->comment('年龄');
            $table->timestamp('birthday')->nullable()->comment('生日');
            $table->string('desc')->nullable()->comment('个性签名');
            $table->string('mobile')->nullable()->comment('手机');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('register_ip')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('register_time')->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
}
