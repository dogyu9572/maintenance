<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 관리자 계정 (homepage/homepagekorea)
        User::create([
            'name' => '홈페이지코리아',
            'login_id' => 'homepage',
            'email' => 'admin@homepagekorea.com',
            'password' => Hash::make('homepagekorea'),
            'is_admin' => true,
            'position' => '관리자',
            'is_active' => true,
        ]);

        // 일반 사용자 계정 (test1/test1234)
        User::create([
            'name' => '테스트사용자',
            'login_id' => 'test1',
            'email' => 'test1@example.com',
            'password' => Hash::make('test1234'),
            'is_admin' => false,
            'position' => '사용자',
            'is_active' => true,
        ]);

        // 기존 테스트 계정들
        User::create([
            'name' => '강심장',
            'login_id' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'position' => '국장',
            'is_active' => true,
        ]);

        User::create([
            'name' => '박은지',
            'login_id' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'position' => '대리',
            'is_active' => true,
        ]);
    }
}
