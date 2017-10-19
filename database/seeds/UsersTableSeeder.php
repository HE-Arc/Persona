<?php

use App\User;
use App\Country;
use App\Personality;
use App\Quality;
use App\FriendRequest;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('fr_CH');

        $limit = 50;

        $user_ids = array();

        for ($i = 0; $i < $limit; $i++) {

            $gender = $faker->numberBetween(0, 1) ? 'm' : 'f';

            //Création d'un nouvel utilisateur
            $user_id = DB::table('users')->insertGetId([
                'gender' => $gender,
                'alias' => $faker->unique()->username,
                'firstname' => $gender == 'm' ? $faker->firstnamemale : $faker->firstnamefemale,
                'lastname' =>$faker->lastname,
                'email' => $faker->unique()->email,
                'password' => "$2y$10\$IA4YRVKACELcfTi7lg9I..KKckGUi12k7WDCo03V2UURpuPboddEu", // okokok
                'country_id' => $faker->numberBetween(1, Country::count()),
                'personality_id' => $faker->numberBetween(1, Personality::count()),
                'birthday' => $faker->dateTimeThisCentury($max = 'now', $timezone = date_default_timezone_get()),
                'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
                'updated_at' => \Carbon\Carbon::now(),  # \Datetime()

            ]);

            //Sauvegarde de l'id du nouvel user dans le tableau d'ids
            $user_ids[] = $user_id;

            $maxQualitiesPerUser = 8;

            $user_qualities_ids = array();

            //Ajout de qualités au nouvel utilisateur
            for ($j=0; $j < $faker->numberBetween(1, $maxQualitiesPerUser); $j++) {

                //Retire une qualité aléatoire si celle-ci a déjà été tirée pour ce user
                do {
                    $current_quality_id = $faker->numberBetween(1, Quality::count());
                } while (in_array($current_quality_id, $user_qualities_ids));

                $user_qualities_ids[] = $current_quality_id;

                DB::table('user_qualities')->insert([
                    'user_id' => $user_id,
                    'quality_id' => $current_quality_id,
                    'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(),  # \Datetime()

                ]);
            }

        }

        $maxRelationPerUser = $limit/2;
        $chanceOfFriendship = 3; // 1/chanceOfFriendship

        foreach ($user_ids as $user_id) {

            for ($i=0; $i < $faker->numberBetween(1, $maxRelationPerUser); $i++) {

                //User aléatoire
                $requested_id = User::where('id', '!=', $user_id)->inRandomOrder()->first()->id;

                $friendship = false;

                //Vérifie si le lien n'existe pas deja
                if(!FriendRequest::getFriendRequestBetweenTwoUsers($user_id, $requested_id)){

                    $reciprocitiy = FriendRequest::getFriendRequestBetweenTwoUsers($requested_id, $user_id);

                    //Vérifie si le lien réciprique existe deja
                    if($reciprocitiy){

                        $friendship = true;
                        //Mise à jour de l'amitié dans l'autre sens
                        FriendRequest::where('id', $reciprocitiy->id)->update(['friendship' => 1]);
                    }
                    //Si pas encore de lien, une chance de créer une amitié directement
                    else if($faker->numberBetween(1, $chanceOfFriendship) == 1){

                        $friendship = true;

                        DB::table('friend_requests')->insert([
                            'requester_id' => $requested_id,
                            'requested_id' => $user_id,
                            'friendship' => $friendship,
                            'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
                            'updated_at' => \Carbon\Carbon::now(),  # \Datetime()
                        ]);

                    }

                    //Création du lien
                    DB::table('friend_requests')->insert([
                        'requester_id' => $user_id,
                        'requested_id' => $requested_id,
                        'friendship' => $friendship,
                        'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
                        'updated_at' => \Carbon\Carbon::now(),  # \Datetime()
                    ]);
                }
            }
        }

        // $generator = \Faker\Factory::create();
        // $populator = new Faker\ORM\Propel\Populator($generator);
        // $populator->addEntity('App\User', 5, array(
        //   'alias' => function() use ($generator) { return $generator->userName(); }
        // ));
        // $insertedPKs = $populator->execute();

        // $populator = populator();
        //
        // $populator->add(User::class, 1, [
        //     'alias'   => $faker->username,
        //     'gender' => $faker->numberBetween(0, 1) ? 'm' : 'f',
        //     'name' => null,
        //     'CreatedAt' => null,
        //     'UpdatedAt' => null,
        //     ])->execute();
    }
}
