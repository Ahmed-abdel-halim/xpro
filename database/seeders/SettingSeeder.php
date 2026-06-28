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
            ['key' => 'contact_phone', 'value' => '01551322666', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@xpro.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'مصر', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '201551322666', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
