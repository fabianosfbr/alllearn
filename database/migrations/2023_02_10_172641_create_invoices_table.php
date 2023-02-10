<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->date('date_end');
            $table->decimal('value', 6,2);
            $table->integer('installment_number');
            $table->string('code_bar');
            $table->string('invoice_url');
            $table->string('bank_slip_url');
            $table->string('description');
            $table->decimal('fine',5,2);
            $table->decimal('interest', 5,2);
            $table->boolean('deleted')->default(false);
            $table->enum('status', ['PENDING','RECEIVED', 'CONFIRMED', 'OVERDUE', 'REFUNDED', 'PAID'])->default('PENDING');
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
        Schema::dropIfExists('invoices');
    }
}
