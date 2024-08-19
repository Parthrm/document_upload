<?php
// database/seeders/DepartmentsTableSeeder.php
// database/seeders/DepartmentsTableSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Department of Agricultural Research and Education'],
            ['name' => 'Department of Agriculture and Farmers Welfare'],
            ['name' => 'Department of Animal Husbandry and Dairying'],
            ['name' => 'Department of Atomic Energy'],
            ['name' => 'Department of BioTechnology'],
            ['name' => 'Department of Chemicals and Petrochemicals'],
            ['name' => 'Department of Commerce'],
            ['name' => 'Department of Drinking Water and Sanitation'],
            ['name' => 'Department of Empowerment of Persons with Disabilities'],
            ['name' => 'Department of Ex Servicemen Welfare'],
            ['name' => 'Department of Fertilizers'],
            ['name' => 'Department of Financial Services'],
            ['name' => 'Department of Fisheries'],
            ['name' => 'Department of Food and Public Distribution'],
            ['name' => 'Department of Health and Family Welfare'],
            ['name' => 'Department of Health Research'],
            ['name' => 'Department of Higher Education'],
            ['name' => 'Department of Home'],
            ['name' => 'Department of Internal Security'],
            ['name' => 'Department of Jammu and Kashmir and Ladakh Affairs'],
            ['name' => 'Department of Pharmaceuticals'],
            ['name' => 'Department of Public Enterprises'],
            ['name' => 'Department of Rural Development'],
            ['name' => 'Department of School Education and Literacy'],
            ['name' => 'Department of Science and Technology'],
            ['name' => 'Department of Scientific and Industrial Research'],
            ['name' => 'Department of Social Justice and Empowerment'],
            ['name' => 'Department of Space'],
            ['name' => 'Department of Sports'],
            ['name' => 'Department of Water Resources, River Development and Ganga Rejuvenation'],
            ['name' => 'Department of Youth Affairs'],
            ['name' => 'Ministry of AYUSH'],
            ['name' => 'Ministry of Culture'],
            ['name' => 'Ministry of Development of North Eastern Region'],
            ['name' => 'Ministry of Earth Science'],
            ['name' => 'Ministry of Electronics and Information Technology'],
            ['name' => 'Ministry of Environment Forest and Climate Change'],
            ['name' => 'Ministry of External Affairs'],
            ['name' => 'Ministry of Heavy Industries'],
            ['name' => 'Ministry of Housing and Urban Affairs'],
            ['name' => 'Ministry of Information and Broadcasting'],
            ['name' => 'Ministry of Labour and Employment'],
            ['name' => 'Ministry of Micro Small and Medium Enterprises'],
            ['name' => 'Ministry of Minority Affairs'],
            ['name' => 'Ministry of New and Renewable Energy'],
            ['name' => 'Ministry of Petroleum and Natural Gas'],
            ['name' => 'Ministry of Railways'],
            ['name' => 'Ministry of Skill Development and Entrepreneurship'],
            ['name' => 'Ministry of Statistics and Programme Implementation'],
            ['name' => 'Ministry of Textiles'],
            ['name' => 'Ministry of Tourism'],
            ['name' => 'Ministry of Tribal Affairs'],
            ['name' => 'Ministry of Women and Child Development'],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert($department);
        }
    }
}
