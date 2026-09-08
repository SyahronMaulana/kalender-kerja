<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (
                    [
                        ['SECURITY','SEC','#F4D35E'],
                        ['CONTROL ROOM','CR','#8200fc'],
                        ['COMPLIANCE','CMP','#e20c0c']
                    ] 
                    as [$name,$code,$color]
                ) 
                    \App\Models\Division::updateOrCreate(
                        ['code'=>$code],
                        [
                            'name'=>$name,
                            'color'=>$color,
                            'is_active'=>true
                        ]
                    );
        // User::updateOrCreate(['email'=>'admin@calendar.test'],['name'=>'Admin Kalender','password'=>'password','role'=>'admin']);
        // User::updateOrCreate(['email'=>'user@calendar.test'],['name'=>'User Kalender','password'=>'password','role'=>'user']);
    }
}
