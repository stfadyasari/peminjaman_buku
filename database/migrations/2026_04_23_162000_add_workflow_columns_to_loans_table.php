<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->date('requested_at')->nullable()->after('book_id');
            $table->date('returned_requested_at')->nullable()->after('due_at');
            $table->timestamp('approved_at')->nullable()->after('returned_at');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            $table->timestamp('return_verified_at')->nullable()->after('approved_by');
            $table->foreignId('return_verified_by')->nullable()->after('return_verified_at')->constrained('users')->nullOnDelete();
            $table->string('condition_status', 30)->nullable()->after('return_verified_by');
            $table->text('condition_note')->nullable()->after('condition_status');
            $table->unsignedInteger('late_fine')->default(0)->after('condition_note');
            $table->unsignedInteger('damage_fine')->default(0)->after('late_fine');
            $table->unsignedInteger('total_fine')->default(0)->after('damage_fine');
            $table->string('fine_payment_status', 20)->default('belum_bayar')->after('total_fine');
            $table->string('fine_payment_method', 20)->nullable()->after('fine_payment_status');
            $table->timestamp('fine_paid_at')->nullable()->after('fine_payment_method');
            $table->string('approval_note', 255)->nullable()->after('fine_paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropConstrainedForeignId('return_verified_by');
            $table->dropColumn([
                'requested_at',
                'returned_requested_at',
                'approved_at',
                'return_verified_at',
                'condition_status',
                'condition_note',
                'late_fine',
                'damage_fine',
                'total_fine',
                'fine_payment_status',
                'fine_payment_method',
                'fine_paid_at',
                'approval_note',
            ]);
        });
    }
};
