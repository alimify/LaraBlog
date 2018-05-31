<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'MR. Admin',
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'password' => bcrypt('theadmin')
        ]);
        DB::table('users')->insert([
            'name' => 'MR. Author',
            'role_id' => 2,
            'username' => 'author',
            'email' => 'author@blog.com',
            'password' => bcrypt('theauthor')
        ]);
    }
}
