<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BeneficiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Fetch existing department IDs
        $departments = DB::table('departments')->pluck('id')->toArray();

        $numRecords = 50; // Number of records to seed, adjust as needed
        $data = [];
        
        for ($i = 0; $i < $numRecords; $i++) {
            // Randomly select a department
            $departmentId = $faker->randomElement($departments);
            
            // Fetch schemes associated with the selected department
            $schemes = DB::table('schemes')
                ->where('department_id', $departmentId)
                ->pluck('name')
                ->toArray();
            
            // Ensure there are schemes available for the selected department
            if (empty($schemes)) {
                continue;
            }

            // Randomly select a scheme for the chosen department
            $schemeName = $faker->randomElement($schemes);

            // Create a record
            $data[] = [
                'department_id' => $departmentId,
                'scheme_name' => $schemeName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('beneficiaries')->insert($data);
    }
}

