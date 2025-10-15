<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HabitsAndInterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('habits')->insert([
            ['id' => 1, 'name' => 'Smoke',                  'icon' => 'smoking.svg',         'parent_id' => null, 'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Yes I Smoke',            'icon' => null,         'parent_id' => 1,    'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'No I Don\'t Smoke',      'icon' => null, 'parent_id' => 1, 'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'I Smoke Sometime',       'icon' => null,       'parent_id' => 1,    'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],

            ['id' => 5, 'name' => 'Drinking',               'icon' => 'cocktail.svg',        'parent_id' => null, 'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Yes I Drink',            'icon' => null,        'parent_id' => 5,    'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'No I Don\'t Drink',      'icon' => null, 'parent_id' => 5, 'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'I Drink Sometime',       'icon' => null,      'parent_id' => 5,    'type' => 'habits', 'created_at' => now(), 'updated_at' => now()],
        ]);

       DB::table('habits')->insert([
            // Food & Drink
            ['id' => 9,  'name' => 'Cooking',          'icon' => 'utensils.svg',        'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Foodie',           'icon' => 'pizza-slice.svg',     'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Vegetarian',       'icon' => 'leaf.svg',            'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Coffee',           'icon' => 'coffee.svg',          'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Wine Tasting',     'icon' => 'wine-glass-alt.svg',  'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Street Food',      'icon' => 'hotdog.svg',          'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Wine & Dine',      'icon' => 'glass-cheers.svg',    'parent_id' => null, 'type' => 'food_and_drink',      'created_at' => now(), 'updated_at' => now()],

            // Travel & Outdoors
            ['id' => 16, 'name' => 'Camping',          'icon' => 'campground.svg',      'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Sunsets',          'icon' => 'sun.svg',             'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Hiking Trips',     'icon' => 'hiking.svg',          'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Skiing',           'icon' => 'skiing.svg',          'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Beach Trips',      'icon' => 'umbrella-beach.svg',  'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Road Trips',       'icon' => 'car.svg',             'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Scuba Diving',     'icon' => 'diving-mask.svg',     'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Museum Visits',    'icon' => 'university.svg',      'parent_id' => null, 'type' => 'travel_and_outdoors',    'created_at' => now(), 'updated_at' => now()],

            // Arts & Culture
            ['id' => 25, 'name' => 'Art',              'icon' => 'palette.svg',         'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Writing',          'icon' => 'pen-nib.svg',         'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Music',            'icon' => 'music.svg',           'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Dancing',          'icon' => 'shoe-prints.svg',     'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Karaoke',          'icon' => 'microphone-alt.svg',  'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Street Art',       'icon' => 'spray-can.svg',       'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Theatre',          'icon' => 'theater-masks.svg',   'parent_id' => null, 'type' => 'arts_and_culture',      'created_at' => now(), 'updated_at' => now()],

            // Sports & Fitness
            ['id' => 32, 'name' => 'Yoga',             'icon' => 'om.svg',              'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Tennis',           'icon' => 'table-tennis.svg',    'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Football',         'icon' => 'football-ball.svg',   'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Snowboarding',     'icon' => 'snowboarding.svg',    'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Running',          'icon' => 'running.svg',         'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Cycling',          'icon' => 'bicycle.svg',         'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Basketball',       'icon' => 'basketball-ball.svg', 'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Golf',             'icon' => 'golf-ball.svg',       'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'Swimming',         'icon' => 'swimmer.svg',         'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'Cricket',          'icon' => 'cricket.svg',         'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'Snooker',          'icon' => 'table-tennis.svg',    'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()], // No snooker icon, reusing table-tennis
            ['id' => 43, 'name' => 'Table Tennis',     'icon' => 'table-tennis.svg',    'parent_id' => null, 'type' => 'sports_and_fitness',   'created_at' => now(), 'updated_at' => now()],

            // Nature & Animals
            ['id' => 44, 'name' => 'Cats',             'icon' => 'cat.svg',             'parent_id' => null, 'type' => 'nature_and_animals',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'Dogs',             'icon' => 'dog.svg',             'parent_id' => null, 'type' => 'nature_and_animals',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'Gardening',        'icon' => 'seedling.svg',        'parent_id' => null, 'type' => 'nature_and_animals',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'Fishing',          'icon' => 'fish.svg',            'parent_id' => null, 'type' => 'nature_and_animals',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'Bird Lover',       'icon' => 'bird.svg',            'parent_id' => null, 'type' => 'lifestyle_and_wellness', 'created_at' => now(), 'updated_at' => now()],

            // Lifestyle & Wellness            
            ['id' => 49, 'name' => 'Meditation',       'icon' => 'spa.svg',             'parent_id' => null, 'type' => 'lifestyle_and_wellness','created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'name' => 'Volunteering',     'icon' => 'hands-helping.svg',   'parent_id' => null, 'type' => 'lifestyle_and_wellness','created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Yoga Retreats',    'icon' => 'pagelines.svg',       'parent_id' => null, 'type' => 'lifestyle_and_wellness','created_at' => now(), 'updated_at' => now()],

            // Hobbies & Games
            ['id' => 51, 'name' => 'Travel Blogging',  'icon' => 'blog.svg',            'parent_id' => null, 'type' => 'hobbies_and_games',  'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'name' => 'Crafts',           'icon' => 'scissors.svg',        'parent_id' => null, 'type' => 'hobbies_and_games',  'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'name' => 'Board Games',      'icon' => 'chess-board.svg',     'parent_id' => null, 'type' => 'hobbies_and_games',  'created_at' => now(), 'updated_at' => now()],
            ['id' => 54, 'name' => 'Podcasts',         'icon' => 'podcast.svg',         'parent_id' => null, 'type' => 'hobbies_and_games',  'created_at' => now(), 'updated_at' => now()],

            // Gaming
            ['id' => 55, 'name' => 'Video Games',      'icon' => 'gamepad.svg',         'parent_id' => null, 'type' => 'gaming',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 56, 'name' => 'Esports',          'icon' => 'trophy.svg',          'parent_id' => null, 'type' => 'gaming',   'created_at' => now(), 'updated_at' => now()],

            // Environment & Social
            ['id' => 57, 'name' => 'Sustainability',   'icon' => 'recycle.svg',         'parent_id' => null, 'type' => 'environment_and_social',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 58, 'name' => 'Festivals',        'icon' => 'calendar-alt.svg',    'parent_id' => null, 'type' => 'environment_and_social',   'created_at' => now(), 'updated_at' => now()],

        ]);

    }
}
