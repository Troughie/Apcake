<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users= [
            ['name'=>'Test User','email'=>'testBanUser1@gmail.com','password'=>bcrypt(12345678),'role'=>'USR'],
            ['name'=>'Test User Ban','email'=>'testBanUser2@gmail.com','password'=>bcrypt(12345678),'role'=>'USR'],
            ['name'=>'Admin','email'=>'admin@gmail.com','password'=>bcrypt(12345678),'role'=>'ADM'],
            ['name'=>'User-Admin','email'=>'user@gmail.com','password'=>bcrypt(12345678),'role'=>'ADC'],
            
        ];
        foreach ($users as $key){
            User::create($key);
        }
    }
}
