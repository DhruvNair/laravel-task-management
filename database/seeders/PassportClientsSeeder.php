<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PassportClientsSeeder extends Seeder
{
    public function run()
    {
        DB::listen(function ($query) {
            Log::info($query->sql);
            Log::info($query->bindings);
        });

        Client::create([
            'user_id' => null,
            'name' => 'Laravel Personal Access Client',
            'secret' => bcrypt(Str::random(40)),
            'provider' => null,
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
        ]);

        Client::create([
            'user_id' => null,
            'name' => 'Laravel Password Grant Client',
            'secret' => bcrypt(Str::random(40)),
            'provider' => null,
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
    }
}
