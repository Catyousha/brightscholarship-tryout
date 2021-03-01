<?php

namespace Database\Seeders;

use App\Models\Bobot;
use App\Models\Choice;
use App\Models\Mapel;
use App\Models\Pilihan;
use App\Models\Question;
use App\Models\Sesi;
use App\Models\Tryout;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TryoutSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bobot = Bobot::all();
        $pilihan = Pilihan::all();
        $mapel = Mapel::all();

        Tryout::factory(3)->state(new Sequence(
            ['pilihan_id' => $pilihan->get(0)->id],
            ['pilihan_id' => $pilihan->get(1)->id],
            ['pilihan_id' => $pilihan->get(2)->id]
        ))->has(
            Sesi::factory()->count(4)->state(new Sequence(
            [
                'mapel_id' => $mapel->get(0)->id,
                'time_start' => Carbon::now(), 'time_end' => Carbon::now()->addHours(1)
            ],
            [
                'mapel_id' => $mapel->get(1)->id,
                'time_start' => Carbon::now()->addHours(1), 'time_end' => Carbon::now()->addHours(2)

            ],
            [
                'mapel_id' => $mapel->get(2)->id,
                'time_start' => Carbon::now()->addHours(2), 'time_end' => Carbon::now()->addHours(3)
            ],
            [
                'mapel_id' => $mapel->get(3)->id,
                'time_start' => Carbon::now()->addHours(3), 'time_end' => Carbon::now()->addHours(4)
            ]
            ))->has(
                Question::factory()->count(5)->state( new Sequence(
                    ['question_num' => 1, 'bobot_id' => $bobot->get(0)->id], ['question_num' => 2, 'bobot_id' => $bobot->get(1)->id],
                    ['question_num' => 3, 'bobot_id' => $bobot->get(2)->id], ['question_num' => 4, 'bobot_id' => $bobot->get(2)->id],
                    ['question_num' => 5, 'bobot_id' => $bobot->get(1)->id]
                ))->has(
                    Choice::factory()->count(5)->state( new Sequence(
                        ['choice_symbol' => 'A'], ['choice_symbol' => 'B'],
                        ['choice_symbol' => 'C', 'correct' => true], ['choice_symbol' => 'D'],
                        ['choice_symbol' => 'E']
                    ))
                )
            )
        )->create();

        /*Tryout::factory(10)->create()->each(function ($t){
            $t->question()->saveMany(
                Question::factory()->count(5)->state(new Sequence(
                    ['question_num' => 1], ['question_num' => 2],
                    ['question_num' => 3], ['question_num' => 4],
                    ['question_num' => 5]
                ))
            );

            $t->question->each(function ($q){
                $q->choice()->saveMany(
                    Choice::factory()->count(5)->state( new Sequence(
                        ['choice_symbol' => 'A'], ['choice_symbol' => 'B'],
                        ['choice_symbol' => 'C'], ['choice_symbol' => 'D'],
                        ['choice_symbol' => 'E']
                    ))
                );
            });
        });*/
    }
}

