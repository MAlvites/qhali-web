<?php

namespace Database\Factories;

use App\Models\BotAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class BotActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BotAction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'name' => $this->faker->word(),
                'url' => $this->faker->url(),
                'img' => "/img/action_avatar.jpg",
                'type' => $this->randomElement([BotAction::TYPE_MOVE, BotAction::TYPE_ACTION])
        ];
    }
}
