<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path_countries = "resources/assets/sql/SqlCountries.sql";
        $path_personalities = "resources/assets/sql/SqlPersonalities.sql";
        $path_qualities = "resources/assets/sql/SqlQualities.sql";

        DB::unprepared(file_get_contents($path_countries));
        DB::unprepared(file_get_contents($path_personalities));
        DB::unprepared(file_get_contents($path_qualities));

        $this->call(UsersTableSeeder::class);
    }
}
