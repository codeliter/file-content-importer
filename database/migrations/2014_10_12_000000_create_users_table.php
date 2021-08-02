<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateUsersTable
 * @author Abolarin Stephen <hackzlord@gmail.com>
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->boolean('checked');
            $table->mediumText('description');
            $table->string('interest')->nullable();
            $table->string('date_of_birth', 50)->nullable();
            $table->string('email');
            $table->string('account');
            $table->string('credit_card');
            $table->string('record_key');
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
        Schema::dropIfExists('users');
    }
}
