<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->insert(['stn_id' => 1, 'stn_name' => 'Versova', 'stn_marathi_name' => 'वर्सोवा', 'stn_code' => 'VER']);
        DB::table('stations')->insert(['stn_id' => 2, 'stn_name' => 'DN Nagar', 'stn_marathi_name' => 'डी एन नगर', 'stn_code' => 'DNG']);
        DB::table('stations')->insert(['stn_id' => 3, 'stn_name' => 'Azad Nagar', 'stn_marathi_name' => 'आझाद नगर', 'stn_code' => 'AZN']);
        DB::table('stations')->insert(['stn_id' => 4, 'stn_name' => 'Andheri', 'stn_marathi_name' => 'अंधेरी', 'stn_code' => 'AND']);
        DB::table('stations')->insert(['stn_id' => 5, 'stn_name' => 'Western Express', 'stn_marathi_name' => 'पश्चिम द्रुतगती महामार्ग', 'stn_code' => 'WEH']);
        DB::table('stations')->insert(['stn_id' => 6, 'stn_name' => 'Chakala JB Nagar', 'stn_marathi_name' => 'चकाला (जे.बी.नगर)', 'stn_code' => 'CHK']);
        DB::table('stations')->insert(['stn_id' => 7, 'stn_name' => 'Airport Road', 'stn_marathi_name' => 'विमानतळ रस्ता', 'stn_code' => 'APR']);
        DB::table('stations')->insert(['stn_id' => 8, 'stn_name' => 'Marol Naka', 'stn_marathi_name' => 'मरोळ नाका', 'stn_code' => 'MAN']);
        DB::table('stations')->insert(['stn_id' => 9, 'stn_name' => 'Saki Naka', 'stn_marathi_name' => 'साकी नाका', 'stn_code' => 'SAN']);
        DB::table('stations')->insert(['stn_id' => 10, 'stn_name' => 'Asalpha', 'stn_marathi_name' => 'असल्फा', 'stn_code' => 'ASA']);
        DB::table('stations')->insert(['stn_id' => 11, 'stn_name' => 'Jagruti Nagar', 'stn_marathi_name' => 'जागृती नगर', 'stn_code' => 'JNG']);
        DB::table('stations')->insert(['stn_id' => 12, 'stn_name' => 'Ghatkopar', 'stn_marathi_name' => 'घाटकोपर', 'stn_code' => 'GHA']);
    }
}
