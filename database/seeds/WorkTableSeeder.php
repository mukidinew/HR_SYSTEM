<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Work;
use App\Models\Person;
use App\Models\Chart;
use \Faker\Factory, Illuminate\Support\Facades\DB;

class WorkTableSeeder extends Seeder
{
	function run()
	{

		DB::table('works')->truncate();
		$faker 										= Factory::create();
		$total_persons  							= Person::count();
		$total_positions 	 						= Chart::count();
		$status 									= ['contract', 'probation', 'internship', 'permanent', 'others', 'previous'];
		$position 									= ['Manager', 'Staff'];
		try
		{
			foreach(range(1, $total_positions) as $index)
			{
				$rand 								= rand(0,4);
				$start 								= $faker->date($format = 'Y-m-d', $max = 'now');
				if(in_array($status[$rand], ['contract', 'probation', 'internship']))
				{
					$end 							= date('Y-m-d', strtotime($start.' + 1 year'));
					$reason_end_job 				= 'end of '.$status[$rand];
				}
				else
				{
					$end 							= null;
					$reason_end_job 				= '';
				}

				$calendar 							= Chart::where('id', $index)->wherehas('calendars', function($q){$q;})->with('calendars')->first();
				$data 								= new Work;
				$data->fill([
					'chart_id'						=> $index,
					'calendar_id'					=> $calendar->calendars[rand(0, count($calendar->calendars)-1)]->id,
					'status'						=> $status[$rand],
					'start'							=> $start,
					'end'							=> $end,
					'reason_end_job'				=> $reason_end_job,
				]);
				if($index==1)
				{
					$person 						= Person::find(1);
				}
				else
				{
					$person 						= Person::find(rand(1,$total_persons));
				}

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}

				$data->Person()->associate($person);
				$data->save();
			} 

			foreach(range(1, 300) as $index)
			{
				$data 								= new Work;
				$data->fill([
					'status'						=> 'previous',//$status[rand(0,3)],
					'start'							=> $faker->date($format = 'Y-m-d', $max = 'now'),
					'end'							=> $faker->date($format = 'Y-m-d', $max = '-3 days'),
					'reason_end_job'				=> $faker->word,
					'position'						=> $position[rand(0,1)],
					'organisation'					=> $faker->company,
				]);

				$person 							= Person::find(rand(1,$total_persons));

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}

				$data->Person()->associate($person);
				$data->save();
			} 
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}	
	}
}