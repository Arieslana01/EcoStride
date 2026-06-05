<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tennis' => [
                'title' => 'EcoStride Tennis Tournament',
                'description' => 'A friendly tennis competition promoting physical fitness and workplace bonding.',
                'image' => 'tennis.png',
                'location' => 'Court A, Green Sports Complex',
                'points' => 30,
            ],
            'Table Tennis' => [
                'title' => 'Friday Ping Pong Challenge',
                'description' => 'Fast-paced table tennis matching to unwind and build active habits.',
                'image' => 'table_tennis.png',
                'location' => 'Rec Room, 3rd Floor Office',
                'points' => 15,
            ],
            'Padel' => [
                'title' => 'Weekend Padel Social',
                'description' => 'Learn and play padel with teammates in a fun, active social gathering.',
                'image' => 'padel.png',
                'location' => 'Padel Arena, City Park',
                'points' => 25,
            ],
            'Mini Soccer' => [
                'title' => 'Mini Soccer League Kick-off',
                'description' => 'Join the annual department mini soccer tournament. Stay active, play clean!',
                'image' => 'mini_soccer.png',
                'location' => 'Eco Field, South Campus',
                'points' => 50,
            ],
            'Yoga' => [
                'title' => 'Mindful Yoga & Breathing Session',
                'description' => 'Restore your mind and body wellness with guided breathing and dynamic stretching.',
                'image' => 'yoga.png',
                'location' => 'Wellness Deck, Rooftop',
                'points' => 20,
            ],
            'Pilates' => [
                'title' => 'Core Pilates & Strength',
                'description' => 'Focus on flexibility, alignment, and core strength in this guided group Pilates session.',
                'image' => 'pilates.png',
                'location' => 'Studio B, Gym Center',
                'points' => 20,
            ],
        ];

        // Seed 6 Open Upcoming Events
        $days = 2;
        foreach ($categories as $category => $info) {
            Event::create([
                'title' => $info['title'],
                'category' => $category,
                'description' => $info['description'],
                'image' => $info['image'],
                'event_date' => Carbon::today()->addDays($days),
                'event_time' => '17:30:00',
                'location' => $info['location'],
                'quota' => 10,
                'points' => $info['points'],
                'status' => 'Open',
            ]);
            $days += 2;
        }

        // Seed 1 Closed Event
        Event::create([
            'title' => 'Closed Tennis Practice',
            'category' => 'Tennis',
            'description' => 'Private training session for the department league team.',
            'image' => 'tennis.png',
            'event_date' => Carbon::today()->addDays(1),
            'event_time' => '15:00:00',
            'location' => 'Court B, Green Sports Complex',
            'quota' => 4,
            'points' => 10,
            'status' => 'Closed',
        ]);

        // Seed 1 Completed Event
        Event::create([
            'title' => 'Introductory Yoga Session',
            'category' => 'Yoga',
            'description' => 'Basic yoga introduction session that took place earlier this week.',
            'image' => 'yoga.png',
            'event_date' => Carbon::today()->subDays(3),
            'event_time' => '08:30:00',
            'location' => 'Wellness Deck, Rooftop',
            'quota' => 25,
            'points' => 15,
            'status' => 'Completed',
        ]);
    }
}
