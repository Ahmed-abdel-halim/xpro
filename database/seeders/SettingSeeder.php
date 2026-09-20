<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            
            // Contact Info
            ['key' => 'contact_phone', 'value' => '07701234567', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@education.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '9647701234567', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
