<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availableHour = $this->faker->numberBetween(10,23); // 10時〜2時
        $minutes = [0,30]; // 30分単位
        $mKey = array_rand($minutes); // ランダムに取得
        $addHour = $this->faker->numberBetween(1,3); // イベント時間 1〜4時

        $dummyDate = $this->faker->dateTimeThisMonth; // 月をランダムで取得
        $startDate = $dummyDate->setTime($availableHour,$minutes[$mKey]);
        $clone = clone $startDate;
        $endDate = $clone->modify('+'.$addHour.'hour');
        // dd($startDate,$endDate); // 確認

        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_visible' => $this->faker->boolean
        ];
    }
}
