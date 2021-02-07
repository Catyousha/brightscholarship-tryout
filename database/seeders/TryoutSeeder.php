<?php

namespace Database\Seeders;

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
        $pilihan = Pilihan::all();
        $mapel = Mapel::all();
        Tryout::factory(10)->state(new Sequence(
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
                'time_start' => Carbon::now()->addHours(2), 'time_end' => Carbon::now()->addHours(3)

            ],
            [
                'mapel_id' => $mapel->get(2)->id,
                'time_start' => Carbon::now()->addHours(4), 'time_end' => Carbon::now()->addHours(5)
            ],
            [
                'mapel_id' => $mapel->get(3)->id,
                'time_start' => Carbon::now()->addHours(6), 'time_end' => Carbon::now()->addHours(7)
            ]
            ))->has(
                Question::factory()->count(5)->state( new Sequence(
                    ['question_num' => 1], ['question_num' => 2],
                    ['question_num' => 3], ['question_num' => 4],
                    ['question_num' => 5]
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

