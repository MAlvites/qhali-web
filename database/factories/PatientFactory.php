<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->firstNameMale(),
            'mother_last_name' => $this->faker->firstNameFemale(),
            'nin' => $this->faker->numerify('########'),
            'age' => $this->faker->numerify('##'),
            'date_birth' => $this->faker->date('Y-m-d', 'now'),
            'civil_status' => $this->faker->randomElement(Patient::CIVIL_STATUSES),
            'birth_sex' => $this->faker->randomElement(Patient::BIRTH_SEXS),
            'sex_orientation' => $this->faker->randomElement(['masculino', 'femenino', 'gay', 'lesbiana', 'transgenero', 'intersexual']),
            'academic_level' => $this->faker->randomElement(['primaria', 'secundaria', 'universitario', 'tecnica', 'pedagogica']),
            'profession' => $this->faker->word(),
            'employment_situation' => $this->faker->randomElement(['empleado', 'desempleado', 'independiente']),
            'address' => $this->faker->address(),
            'district' => $this->faker->word(),
            'phone_number' => $this->faker->numerify('9########'),
            'email' => $this->faker->email(),
            'created_at' => now()
        ];
    }
}
