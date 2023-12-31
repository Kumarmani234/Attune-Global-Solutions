<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_details', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id')->nullable()->default(null)->unique(); // Unique instead of primary
            $table->string('vendor_name');
            $table->string('vendor_image');
            $table->string('contact_person');
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('tax_id')->unique()->nullable();
            $table->string('registration_number')->unique()->nullable();
            $table->date('contract_start_date')->nullable(); // Change to date
            $table->date('contract_end_date')->nullable();   // Change to date
            $table->decimal('contract_value', 10, 2)->nullable(); // Change to decimal
            $table->string('payment_terms')->nullable();
            $table->text('product_or_service_description')->nullable(); // Change to text
            $table->text('pricing_information')->nullable(); // Change to text
            $table->text('business_registration_certificate')->nullable(); // Change to text
            $table->text('licenses_and_permits')->nullable(); // Change to text
            $table->text('insurance_documents')->nullable(); // Change to text
            $table->text('past_performance_history')->nullable(); // Change to text
            $table->text('references')->nullable(); // Change to text
            $table->text('terms_and_conditions')->nullable(); // Change to text
            $table->text('service_level_agreements')->nullable(); // Change to text
            $table->text('non_disclosure_agreements')->nullable(); // Change to text
            $table->text('quality_control_measures')->nullable(); // Change to text
            $table->text('industry_compliance')->nullable(); // Change to text
            $table->string('primary_point_of_contact')->nullable();
            $table->text('communication_channels')->nullable(); // Change to text
            $table->text('support_availability')->nullable(); // Change to text
            $table->text('reporting_requirements')->nullable(); // Change to text
            $table->text('access_for_audits')->nullable(); // Change to text
            $table->text('monitoring_processes')->nullable(); // Change to text
            $table->text('termination_conditions')->nullable(); // Change to text
            $table->text('renewal_terms')->nullable(); // Change to text
            $table->text('integration_processes')->nullable(); // Change to text
            $table->text('vendor_onboarding_process')->nullable(); // Change to text
            $table->text('training_requirements')->nullable();
            $table->string('password')->nullable(); // Change to text
            $table->string('company_id');
            $table->string('status')->default(1);
            $table->foreign('company_id')
                ->references('company_id') // Assuming the primary key of the companies table is 'id'
                ->on('company_details')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->timestamps();
        });

        $triggerSQL = <<<SQL
        CREATE TRIGGER generate_vendor_id BEFORE INSERT ON vendor_details FOR EACH ROW
        BEGIN
            -- Check if vendor_id is NULL
            IF NEW.vendor_id IS NULL THEN
                -- Find the maximum vendor_id value in the emp_details table
                SET @max_id := IFNULL((SELECT MAX(CAST(SUBSTRING(vendor_id, 3) AS UNSIGNED)) + 1 FROM  vendor_details), 100000);

                -- Increment the max_id and assign it to the new vendor_id
                SET NEW.vendor_id = CONCAT('55', LPAD(@max_id, 6, '0'));
            END IF;
        END;
    SQL;

    DB::unprepared($triggerSQL);

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_details');
    }
};
