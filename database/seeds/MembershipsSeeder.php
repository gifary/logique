<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'name' => "Silver"
        ]);

        DB::table('memberships')->insert([
            'name' => "Gold"
        ]);

        DB::table('memberships')->insert([
            'name' => "Platinum"
        ]);

        DB::table('memberships')->insert([
            'name' => "Black"
        ]);

        DB::table('memberships')->insert([
            'name' => "VIP"
        ]);

        DB::table('memberships')->insert([
            'name' => "VVIP"
        ]);
    }
}
