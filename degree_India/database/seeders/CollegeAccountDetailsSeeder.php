<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CollegeAccountDetailsSeeder extends Seeder
{
    public function run(): void
    {
       
        $accountDetails = [
            [
                'college_id' => 2,
                'account_holder_name' => 'Delhi University',
                'bank_name' => 'State Bank of India',
                'account_number' => '123456789012',
                'ifsc_code' => 'SBIN0001234',
                'branch_name' => 'Delhi University Branch, New Delhi',
                'account_type' => 'savings',
                'micr_code' => '110002123',
                'upi_id' => 'delhiuniversity@sbi',
                'registered_mobile' => '+919876543210',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'college_id' => 3,
                'account_holder_name' => 'IIT Bombay',
                'bank_name' => 'HDFC Bank',
                'account_number' => '987654321098',
                'ifsc_code' => 'HDFC0000456',
                'branch_name' => 'Powai Branch, Mumbai',
                'account_type' => 'current',
                'micr_code' => '400076456',
                'upi_id' => 'iitbombay@hdfcbank',
                'registered_mobile' => '+919887766554',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'college_id' => 4,
                'account_holder_name' => 'Anna University',
                'bank_name' => 'ICICI Bank',
                'account_number' => '456789012345',
                'ifsc_code' => 'ICIC0000789',
                'branch_name' => 'Guindy Branch, Chennai',
                'account_type' => 'savings',
                'micr_code' => '600032789',
                'upi_id' => 'annauniversity@icici',
                'registered_mobile' => '+919776655443',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'college_id' => 5,
                'account_holder_name' => 'University of Calcutta',
                'bank_name' => 'Punjab National Bank',
                'account_number' => '112233445566',
                'ifsc_code' => 'PNB0012345',
                'branch_name' => 'College Street Branch, Kolkata',
                'account_type' => 'current',
                'micr_code' => '700073234',
                'upi_id' => 'calcuttauniversity@pnb',
                'registered_mobile' => '+919665544332',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'college_id' => 6,
                'account_holder_name' => 'University of Hyderabad',
                'bank_name' => 'Axis Bank',
                'account_number' => '998877665544',
                'ifsc_code' => 'UTIB0000999',
                'branch_name' => 'Gachibowli Branch, Hyderabad',
                'account_type' => 'savings',
                'micr_code' => '500032999',
                'upi_id' => 'uohyd@axisbank',
                'registered_mobile' => '+919554433221',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Clear existing data
        DB::table('college_account_details')->truncate();
        
        // Insert new data
        foreach ($accountDetails as $detail) {
            DB::table('college_account_details')->insert($detail);
        }

        $this->command->info('✓ College account details seeded successfully!');
        $this->command->info('Total records: ' . count($accountDetails));
    }
}