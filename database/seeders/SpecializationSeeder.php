<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSpecializations = [
            'رياضيات',
            'فيزياء',
            'كيمياء',
            'إنكليزي',
            'أحياء',
            'اللغة العربية',
            'إسلامية',
            'اجتماعيات',
            'حاسوب',
        ];

        foreach ($defaultSpecializations as $name) {
            Specialization::firstOrCreate(['name' => $name]);
        }
    }
}
