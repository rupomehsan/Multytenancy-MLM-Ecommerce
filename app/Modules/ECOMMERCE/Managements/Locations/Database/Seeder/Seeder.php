<?php

namespace App\Modules\ECOMMERCE\Managements\Locations\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\ECOMMERCE\Managements\Locations\Database\Seeder\Seeder"
     */
    public function run(): void
    {
        $this->seedDivisions();
        $this->seedDistricts();
        $this->seedUpazilas();
        $this->seedUnions();
    }

    private function seedDivisions()
    {
        $divisions = [
            ['id' => 1, 'name' => 'Chattagram', 'bn_name' => 'চট্টগ্রাম', 'url' => 'www.chittagongdiv.gov.bd'],
            ['id' => 2, 'name' => 'Rajshahi', 'bn_name' => 'রাজশাহী', 'url' => 'www.rajshahidiv.gov.bd'],
            ['id' => 3, 'name' => 'Khulna', 'bn_name' => 'খুলনা', 'url' => 'www.khulnadiv.gov.bd'],
            ['id' => 4, 'name' => 'Barisal', 'bn_name' => 'বরিশাল', 'url' => 'www.barisaldiv.gov.bd'],
            ['id' => 5, 'name' => 'Sylhet', 'bn_name' => 'সিলেট', 'url' => 'www.sylhetdiv.gov.bd'],
            ['id' => 6, 'name' => 'Dhaka', 'bn_name' => 'ঢাকা', 'url' => 'www.dhakadiv.gov.bd'],
            ['id' => 7, 'name' => 'Rangpur', 'bn_name' => 'রংপুর', 'url' => 'www.rangpurdiv.gov.bd'],
            ['id' => 8, 'name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ', 'url' => 'www.mymensinghdiv.gov.bd'],
        ];

        foreach ($divisions as $division) {
            DB::table('divisions')->insert(array_merge($division, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }

    private function seedDistricts()
    {
        $sqlFile = base_path('location.sql');
        if (!file_exists($sqlFile)) {
            $this->command->error('location.sql file not found!');
            return;
        }

        $sql = file_get_contents($sqlFile);

        // Extract districts INSERT statements
        preg_match('/INSERT INTO `districts`.*?VALUES\s*(.*?);/s', $sql, $matches);

        if (isset($matches[1])) {
            $values = $matches[1];
            // Parse each row
            preg_match_all('/\((\d+),\s*(\d+),\s*\'([^\']*)\',\s*\'([^\']*)\',\s*\'([^\']*)\',\s*\'([^\']*)\',\s*\'([^\']*)\',\s*(\d+(?:\.\d+)?)\)/', $values, $rows, PREG_SET_ORDER);

            foreach ($rows as $row) {
                DB::table('districts')->insert([
                    'id' => $row[1],
                    'division_id' => $row[2],
                    'name' => $row[3],
                    'bn_name' => $row[4],
                    'lat' => $row[5] ?: null,
                    'lon' => $row[6] ?: null,
                    'url' => $row[7] ?: null,
                    'delivery_charge' => $row[8],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    private function seedUpazilas()
    {
        $sqlFile = base_path('location.sql');
        if (!file_exists($sqlFile)) {
            $this->command->error('location.sql file not found!');
            return;
        }

        $sql = file_get_contents($sqlFile);

        // Extract upazilas INSERT statements
        preg_match('/INSERT INTO `upazilas`.*?VALUES\s*(.*?);/s', $sql, $matches);

        if (isset($matches[1])) {
            $values = $matches[1];
            // Parse each row
            preg_match_all('/\((\d+),\s*(\d+),\s*\'([^\']*)\',\s*\'([^\']*)\',\s*\'([^\']*)\'\)/', $values, $rows, PREG_SET_ORDER);

            foreach ($rows as $row) {
                DB::table('upazilas')->insert([
                    'id' => $row[1],
                    'district_id' => $row[2],
                    'name' => $row[3],
                    'bn_name' => $row[4] ?: null,
                    'url' => $row[5] ?: null,
                    'lat' => null,
                    'lon' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    private function seedUnions()
    {
        $sqlFile = base_path('location.sql');
        if (!file_exists($sqlFile)) {
            $this->command->error('location.sql file not found!');
            return;
        }

        $sql = file_get_contents($sqlFile);

        // Extract unions INSERT statements
        preg_match('/INSERT INTO `unions`.*?VALUES\s*(.*?);/s', $sql, $matches);

        if (isset($matches[1])) {
            $values = $matches[1];
            // Parse each row
            preg_match_all('/\((\d+),\s*(\d+),\s*\'([^\']*)\',\s*\'([^\']*)\',\s*\'([^\']*)\'\)/', $values, $rows, PREG_SET_ORDER);

            foreach ($rows as $row) {
                DB::table('unions')->insert([
                    'id' => $row[1],
                    'upazila_id' => $row[2],
                    'name' => $row[3],
                    'bn_name' => $row[4] ?: null,
                    'url' => $row[5] ?: null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
