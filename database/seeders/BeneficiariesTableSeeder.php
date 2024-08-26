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
        $talukas = [
            ["Bardez","Pernem","Bicholim","Tiswadi","Sattari","Ponda"],
            ["Sanguem","Dharbandora","Salcete","Quepem","Canacona","Mormugao"]
        ];
        $district = ["North Goa","South Goa"];
        // Fetch existing department IDs
        $departments = DB::table('departments')->pluck('id')->toArray();

        if (empty($departments)) {
            echo "No departments found.\n";
            return;
        }

        $numRecords = 1500;
        $data = [];

        for ($i = 0; $i < $numRecords; $i++) {
            $departmentId = $faker->randomElement($departments);
            
            $schemes = DB::table('schemes')
                ->where('department_id', $departmentId)
                ->pluck('id')
                ->toArray();
            
            if (empty($schemes)) {
                echo "No schemes found for department ID: $departmentId\n";
                continue;
            }

            $schemeId = $faker->randomElement($schemes);
            $district_number = ($faker->randomNumber(1))%2;
            
            $data[] = [
                'name' => $faker->name(),
                'department_id' => $departmentId,
                'district' => $district[$district_number],
                'taluka' => $faker->randomElement($talukas[$district_number]),
                'aadhaar_seeded' => $faker->randomElement([1,0]),
                'bank_seeded' => $faker->randomElement([1,0]),
                'scheme_id' => $schemeId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            DB::table('beneficiaries')->insert($data);
            echo "Seeded $numRecords records.\n";
        } else {
            echo "No data to insert.\n";
        }
    }
}

