<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\document;
use App\Models\successStory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\successStoryFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        document::factory(24)->create();
        document::factory()->create([
                'title' => "The Aadhaar (Targeted Delivery of Financial and Other Subsidies, Benefits and Services) Act, 2016",
                'tags' => "aadhaar,people",
                'description' => "An Act to provide for, as a good governance, efficient, transparent, and targeted delivery of subsidies, benefits and services, the expenditure for which is incurred from the Consolidated Fund of India, to individuals residing in India through assigning of unique identity numbers to such individuals and for matters connected therewith or incidental thereto.",
                'path' => "documents/Wzq4JuGGXap49dGv3oCl8H1tahUYpKmbe8ASIx5A.pdf",
        ]);
        
        
        successStory::factory(10)->create();
        successStory::factory()->create([
                'title' => "Best Practice in respect to Pradhan Mantri Matru Vandana Yojana (PMMVY)",
                'author' => "Ministry of Women and Child Development",
                'description' => "Under-nutrition continues to adversely affect majority of women in India. In India, every third woman is undernourished and every second woman is anemic. An undernourished mother almost inevitably gives birth to a low birth weight baby. When poor nutrition starts in-utero, it extends throughout the life cycle since the changes are largely irreversible. Owing to economic and social distress many women continue to work to earn a living for their family right up to the last days of their pregnancy. Furthermore, they resume working soon after childbirth, even though their bodies might not permit it, thus preventing their bodies from fully recovering on one hand, and also impeding their ability to exclusively breastfeed their young infant in the first six months.",
                'path' => "66a2451289aae",
        ]);
        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(SchemesTableSeeder::class);
        $this->call(BeneficiariesTableSeeder::class);
    }
}
