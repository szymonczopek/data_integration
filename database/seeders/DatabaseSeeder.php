<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Laptop;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $data=[
                ['manufacturer' => 'Lenovo',
                'size' => '14"',
                'resolution' => '1200x800',
                'screenType' => 'matowa',
                'touch' => 'tak',
                'processorName' => 'intel i7',
                'physicalCores' => 8,
                'clockSpeed' => 3600,
                'ram' => '16GB',
                'storage' => '512GB',
                'discType' => 'SSD',
                'graphicCardName' => 'NVIDIA GeForce GTX 1050',
                'memory' => '6GB',
                'os' => 'Windows 10',
                'disc_reader' => 'brak'],

            ['manufacturer' => 'Sony',
                'size' => '13"',
                'resolution' => '1300x800',
                'screenType' => 'blyszczaca',
                'touch' => 'nie',
                'processorName' => 'intel i5',
                'physicalCores' => 4,
                'clockSpeed' => 3000,
                'ram' => '12GB',
                'storage' => '512GB',
                'discType' => 'HDDD',
                'graphicCardName' => 'NVIDIA GeForce GTX 1660',
                'memory' => '6GB',
                'os' => 'Windows 10',
                'disc_reader' => 'tak'],

            ['manufacturer' => 'Oppo',
                'size' => '17"',
                'resolution' => '1280x5600',
                'screenType' => 'blyszczaca',
                'touch' => 'tak',
                'processorName' => 'intel i5',
                'physicalCores' => 4,
                'clockSpeed' => 3000,
                'ram' => '12GB',
                'storage' => '512GB',
                'discType' => 'HDDD',
                'graphicCardName' => 'NVIDIA GeForce GTX 1660',
                'memory' => '6GB',
                'os' => 'Windows 10',
                'disc_reader' => 'tak'],
        ];
        Laptop::insert($data);
    }
}
