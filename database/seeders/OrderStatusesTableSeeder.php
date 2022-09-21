<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $settings = [
        [
            'order_status'                       =>  'pending',
        ],
        [
            'order_status'                       =>  'processing',
        ],
        [
            'order_status'                       =>  'completed',
        ],
        [
            'order_status'                       =>  'decline',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $key => $value) {
            $result = OrderStatus::create($value);
            if (!$result) {
                $this->command->info("Insert failed at record $key.");
                return;
            }
        }
        $this->command->info('Inserted ' . count($this->settings) . ' records');
    }
}
