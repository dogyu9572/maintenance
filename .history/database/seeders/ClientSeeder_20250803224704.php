<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => '강동성심병원',
                'client_type' => 'company',
                'is_manpower_check' => true,
                'monthly_report_enabled' => true,
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'website_url' => 'https://gangdong.smc.or.kr',
                'is_active' => true,
            ],
            [
                'name' => '서울대학교병원',
                'client_type' => 'company',
                'is_manpower_check' => true,
                'monthly_report_enabled' => true,
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'website_url' => 'https://www.snuh.org',
                'is_active' => true,
            ],
            [
                'name' => '삼성서울병원',
                'client_type' => 'company',
                'is_manpower_check' => true,
                'monthly_report_enabled' => true,
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'website_url' => 'https://www.samsunghospital.com',
                'is_active' => true,
            ],
            [
                'name' => '아산병원',
                'client_type' => 'company',
                'is_manpower_check' => true,
                'monthly_report_enabled' => true,
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'website_url' => 'https://www.amc.seoul.kr',
                'is_active' => true,
            ],
            [
                'name' => '연세대학교병원',
                'client_type' => 'company',
                'is_manpower_check' => true,
                'monthly_report_enabled' => true,
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'website_url' => 'https://www.yuhs.or.kr',
                'is_active' => true,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
} 