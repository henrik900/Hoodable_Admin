<?php

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
        	'first_name'        => 'Saurabh',
            'last_name'         => 'Kumar',
            'email'             => 'admin@admin.com',
            'password'          => bcrypt('123456'),
            'phone'             => '9616082011',
            'active'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
    }
}
