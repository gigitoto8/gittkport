<?php

use Illuminate\Database\Seeder;

class Account_itemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_items')->insert([
            [
                'id' => '00001',
                'accnt_class' => '-',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00100',
                'accnt_class' => '食費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00200',
                'accnt_class' => '日用雑貨',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00300',
                'accnt_class' => '被服費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00400',
                'accnt_class' => '美容費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00500',
                'accnt_class' => '交際費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00600',
                'accnt_class' => '遊興費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00700',
                'accnt_class' => '交通費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00800',
                'accnt_class' => '教育費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '00900',
                'accnt_class' => '医療費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01000',
                'accnt_class' => '車両費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01100',
                'accnt_class' => '賃借料',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01200',
                'accnt_class' => '通信費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01300',
                'accnt_class' => '保険料',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01400',
                'accnt_class' => '水道光熱費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '01500',
                'accnt_class' => '住宅費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '05000',
                'accnt_class' => '雑費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '05100',
                'accnt_class' => '特別費',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '05200',
                'accnt_class' => '社会保障',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
            [
                'id' => '05300',
                'accnt_class' => '税金',
                'created_at' => '2024-09-19 18:00:00',
                'updated_at' => '2024-09-19 18:00:00'
            ],
        ]);
    }
}
