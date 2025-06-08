<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['USD', 'US Dollar', 1, '$'],
            ['EUR', 'Euro', 0.92, '€'],
            ['GBP', 'British Pound', 0.79, '£'],
            ['NGN', 'Nigerian Naira', 1450, '₦'],
            ['KES', 'Kenyan Shilling', 130, 'KSh'],
            ['UGX', 'Ugandan Shilling', 3750, 'UGX'],
            ['GHS', 'Ghanaian Cedi', 14, 'GH₵'],
            ['ZAR', 'South African Rand', 18, 'R'],
            ['TZS', 'Tanzanian Shilling', 2500, 'TSh'],
            ['MWK', 'Malawian Kwacha', 1700, 'MK'],
            ['SLL', 'Sierra Leonean Leone', 21000, 'Le'],
            ['XAF', 'Central African CFA Franc', 600, 'FCFA'],
            ['XOF', 'West African CFA Franc', 610, 'CFA'],
            ['GNF', 'Guinean Franc', 8700, 'FG'],
            ['MAD', 'Moroccan Dirham', 10, 'MAD'],
            ['MUR', 'Mauritian Rupee', 45, '₨'],
            ['ZMW', 'Zambian Kwacha', 24, 'ZK'],
            ['RWF', 'Rwandan Franc', 1250, 'RF'],
            ['ETB', 'Ethiopian Birr', 57, 'Br'],
            ['INR', 'Indian Rupee', 83, '₹'],
            ['JPY', 'Japanese Yen', 155, '¥'],
            ['CAD', 'Canadian Dollar', 1.35, 'C$'],
            ['AUD', 'Australian Dollar', 1.5, 'A$'],
            ['NZD', 'New Zealand Dollar', 1.6, 'NZ$'],
            ['CHF', 'Swiss Franc', 0.91, 'CHF'],
            ['NOK', 'Norwegian Krone', 10, 'kr'],
            ['PLN', 'Polish Zloty', 4.1, 'zł'],
            ['CZK', 'Czech Koruna', 22, 'Kč'],
            ['ILS', 'Israeli Shekel', 3.6, '₪'],
            ['ARS', 'Argentine Peso', 900, '$'],
            ['PEN', 'Peruvian Sol', 3.8, 'S/.'],
            ['MYR', 'Malaysian Ringgit', 4.7, 'RM'],
            ['RUB', 'Russian Ruble', 92, '₽'],
            ['AED', 'Emirati Dirham', 3.67, 'د.إ']
        ];

        foreach ($currencies as [$code, $name, $rate, $symbol]) {
            Currency::updateOrCreate(['code' => $code], [
                'name' => $name,
                'exchange_rate' => $rate,
                'symbol' => $symbol,
                'is_active' => true,
            ]);
        }
    }
}

