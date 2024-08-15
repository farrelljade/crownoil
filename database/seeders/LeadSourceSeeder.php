<?php

namespace Database\Seeders;

use App\Enums\LeadSourceEnum;
use App\Models\LeadSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert each enum value into the LeadSource table
        foreach (LeadSourceEnum::cases() as $source) {
            LeadSource::updateOrCreate(['name' => $source->value]);
        }
    }
}
