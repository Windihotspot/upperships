<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->string('sender_name');
            $table->string('sender_address')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_address')->nullable();
            $table->decimal('package_weight', 8, 2);
            $table->enum('status', ['Pending', 'Shipped', 'Delivered'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
