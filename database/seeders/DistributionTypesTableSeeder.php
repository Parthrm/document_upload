<?php
// database/seeders/DistributionTypesTableSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributionTypesTableSeeder extends Seeder
{
    public function run()
    {
        $distributionTypes = [
            'Area Wise Distribution',
            'Aadhar Seeded Distribution',
            'Bank account linked Distribution',
            'Male-Female Distribution',
            'Beneficiary Count',
        ];

        foreach ($distributionTypes as $type) {
            DB::table('distribution_types')->insert(['name' => $type]);
        }
    }
}

