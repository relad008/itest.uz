<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->increments('id');
            $Ashufle_map=['A','B','C','D'];
            $shufle_map=['-'];
			foreach ($Ashufle_map as $ind=>$varA)
			{
				$Bshufle_map=$Ashufle_map;
				unset($Bshufle_map[$ind]);
				foreach ($Bshufle_map as $ind=>$varB)
				{
					$Cshufle_map=$Bshufle_map;
					unset($Cshufle_map[$ind]);
					foreach ($Cshufle_map as $ind=>$varC)
					{
						$Dshufle_map=$Cshufle_map;
						unset($Dshufle_map[$ind]);
						$varD=array_shift($Dshufle_map);
						$shufle_map[]="$varA-$varB-$varC-$varD";
					}
				}

			}
             $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    		$table->timestamp('updated_at');
			$table->integer('user_id');
			$table->enum('status',['started','finished'])->default('started');
			$table->enum('type',['demo','thematic','direction']);
			$table->enum('shuffle_map',$shufle_map)->default('-');

			$table->integer('total_correct');
			$table->integer('total_questions');
			$table->datetime('end_at');

			for ($i=1; $i <=3; $i++)
			{
				$table->integer('correct_count_'.$i);
				$table->integer('questions_count_'.$i);
				$table->integer('subject_id_'.$i);
			}
			$correct_vals=$answer_vals=$Ashufle_map;
			$answer_vals[]='no_answer';
			$correct_vals[]="no_question";

			for ($i=1; $i <=3 ; $i++)
			{
				for ($j=1; $j <= 36; $j++)
				{
					$table->integer("question_id_{$i}_{$j}");
					// CORRECT-ANSWERED or -NO_QUESTION
					$table->enum("answer_{$i}_{$j}",$answer_vals)->default('no_answer');
					$table->enum("answer_correct_{$i}_{$j}",$correct_vals)->default('no_question');
				}
			}

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('test_sessions');
    }
}
