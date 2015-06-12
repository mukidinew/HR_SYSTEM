<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/* ----------------------------------------------------------------------
 * Document Model:
 * 	ID 								: Auto Increment, Integer, PK
 * 	organisation_id 				: Foreign Key From Organisation, Integer, Required
 * 	name 		 					: Required max 255
 * 	workdays 		 				: Text
 * 	start 		 					: Required time
 * 	end 		 					: Required time
 *	created_at						: Timestamp
 * 	updated_at						: Timestamp
 * 	deleted_at						: Timestamp
 * 
/* ----------------------------------------------------------------------
 * Document Relationship :
 * 	//this package
 	1 Relationship hasMany 
	{
		Schedules
	}

 * 	//other package
 	1 Relationship belongsTo 
	{
		Organisation
	}

 * 	//other package
 	1 Relationship belongsToMany 
	{
		Charts
	}

 * ---------------------------------------------------------------------- */

use Str, Validator, DateTime, Exception;

class Calendar extends BaseModel {

	use SoftDeletes;
	use \App\Models\Traits\BelongsTo\HasOrganisationTrait;
	use \App\Models\Traits\HasMany\HasSchedulesTrait;
	use \App\Models\Traits\BelongsToMany\HasChartsTrait;

	public 		$timestamps 		= 	true;

	protected 	$table 				= 	'tmp_calendars';
	
	protected 	$fillable			= 	[
											'name' 						,
											'workdays' 					,
											'start' 					,
											'end' 						,
										];

	protected 	$rules				= 	[
											'name'						=> 'required|max:255',
											'start'						=> 'required|date_format:"H:i:s"',
											'end'						=> 'required|date_format:"H:i:s"',
										];

	public $searchable 				= 	[
											'id' 						=> 'ID', 
											'organisationid' 			=> 'OrganisationID', 
											'name' 						=> 'Name', 
											'orname' 					=> 'OrName', 

											'branchid' 					=> 'BranchID', 
											'charttag' 					=> 'ChartTag', 
											
											'withattributes' 			=> 'WithAttributes'
										];

	public $searchableScope 		= 	[
											'id' 						=> 'Could be array or integer', 
											'organisationid' 			=> 'Could be array or integer', 
											'name' 						=> 'Must be string', 
											'orname' 					=> 'Could be array or string', 

											'branchid' 					=> 'Could be array or integer', 
											'charttag' 					=> 'Must be string', 
											
											'withattributes' 			=> 'Must be array of relationship',
										];

	public $sortable 				= 	['created_at', 'name'];

	/* ---------------------------------------------------------------------------- CONSTRUCT ----------------------------------------------------------------------------*/
	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/
	static function boot()
	{
		parent::boot();

		Static::saving(function($data)
		{
			$validator = Validator::make($data->toArray(), $data->rules);

			if ($validator->passes())
			{
				return true;
			}
			else
			{
				$data->errors = $validator->errors();
				return false;
			}
		});
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ---------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- FUNCTIONS -------------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	public function scopeName($query, $variable)
	{
		return $query->where('name', 'like', '%'.$variable.'%');
	}

	public function scopeOrName($query, $variable)
	{
		if(is_array($variable))
		{
			foreach ($variable as $key => $value) 
			{
				$query = $query->orwhere('name', 'like', '%'.$value.'%');
			}
			return $query;
		}
		return $query->where('name', 'like', '%'.$variable.'%');
	}

}
