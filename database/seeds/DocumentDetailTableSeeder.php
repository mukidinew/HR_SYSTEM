<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonDocument;
use App\Models\Person;
use App\Models\DocumentDetail;
use \Faker\Factory;
use Illuminate\Support\Facades\DB;

class DocumentDetailTableSeeder extends Seeder
{
	function run()
	{
		DB::table('documents_details')->truncate();

		$faker 										= Factory::create();
		$total_documents 							= PersonDocument::count();
		try
		{
			foreach(range(1, $total_documents) as $index)
			{
				$person 							= PersonDocument::find($index);
				
				$person2 							= Person::find($person->person_id);

				foreach ($person2->Documents as $key => $value) 
				{
					if($value->id == $person->document_id)
					{
						foreach ($person2->documents[$key]->templates as $key2 => $value2)
						{
							$detail[$key2] 			= new DocumentDetail;
							
							switch ($value2->type) 
							{
								case 'date':
									$detail[$key2]->fill([
										'template_id'		=> $value2->id,
										'on'				=> $faker->date,
									]);
									break;
								
								case 'numeric':
									$detail[$key2]->fill([
										'template_id'		=> $value2->id,
										'numeric'			=> rand(20,100),
									]);
									break;

								case 'string':
									$detail[$key2]->fill([
										'template_id'		=> $value2->id,
										'string'			=> $faker->name,
									]);
									break;

								default:
									$detail[$key2]->fill([
										'template_id'		=> $value2->id,
										'text'				=> $faker->word,
									]);
									break;
							}
							$detail[$key2]->PersonDocument()->associate($person);
							$detail[$key2]->save();
						} 
					}
				}
			}
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}	
	}
}