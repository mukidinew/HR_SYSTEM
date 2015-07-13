<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/* ----------------------------------------------------------------------
 * Document Model:
 * 	ID 								: Auto Increment, Integer, PK
 * 	chart_id 						: Foreign Key From Chart, Integer, Required if position and organisation not present
 * 	person_id 						: Foreign Key From Person, Integer, Required
 * 	calendar_id 					: Foreign Key From Calendar, Integer, Required
 * 	status 		 					: Enum contract or probation or internship or permanent or others or previous
 * 	start 							: Date, Y-m-d, Required
 * 	end 							: Date, Y-m-d
 * 	position 						: required if chart_id not present
 * 	organisation 					: required if chart_id not present
 * 	reason_end_job 					: required if end present
 *	created_at						: Timestamp
 * 	updated_at						: Timestamp
 * 	deleted_at						: Timestamp
 * 
/* ----------------------------------------------------------------------
 * Document Relationship :
 * 	//other package
 	3 Relationships belongsTo 
	{
		Chart
		Person
		Calendar
	}

 * ---------------------------------------------------------------------- */

use Str, Validator, DateTime, Exception;

class Work extends BaseModel {

	//use SoftDeletes;
	use \App\Models\Traits\BelongsTo\HasChartTrait;
	use \App\Models\Traits\BelongsTo\HasPersonTrait;
	use \App\Models\Traits\BelongsTo\HasCalendarTrait;
	use \App\Models\Traits\HasMany\HasWorkAuthenticationsTrait;

	public 		$timestamps 		= 	true;

	protected 	$table 				= 	'works';

	protected 	$fillable			= 	[
											'calendar_id' 				,
											'chart_id' 					,
											'status' 					,
											'start' 					,
											'end' 						,
											'position' 					,
											'organisation' 				,
											'reason_end_job' 			,
										];

	protected 	$rules				= 	[
											'chart_id'					=> 'required_without:position',
											'status' 					=> 'required|in:contract,probation,internship,permanent,others,admin,previous',
											'start' 					=> 'required|date_format:"Y-m-d"',
											'end' 						=> 'required_if:status,contract,probation,internship,previous|date_format:"Y-m-d"',
											'position' 					=> 'required_without:chart_id',
											'organisation' 				=> 'required_without:chart_id',
											'reason_end_job' 			=> 'required_with:end',
										];

	public $searchable 				= 	[
											'id' 						=> 'ID', 
											'calendarid' 				=> 'CalendarID', 
											'chartid' 					=> 'ChartID', 
											'personid' 					=> 'PersonID', 
											'status' 					=> 'Status', 
											'active' 					=> 'Active', 
											'withattributes' 			=> 'WithAttributes'
										];

	public $searchableScope 		= 	[
											'id' 						=> 'Could be array or integer', 
											'calendarid' 				=> 'Could be array or integer', 
											'chartid' 					=> 'Could be array or integer', 
											'personid' 					=> 'Could be array or integer', 
											'status' 					=> 'Could be array or string', 
											'active' 					=> 'Must be enddate of work', 
											'withattributes' 			=> 'Must be array of relationship',
										];

	public $sortable 				= 	['created_at', 'start', 'end'];

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

	public function scopeID($query, $variable)
	{
		if(is_array($variable))
		{
			return $query->whereIn('works.id', $variable);
		}
		return $query->where('works.id', $variable);
	}
	
	public function scopeStatus($query, $variable)
	{
		if(is_array($variable))
		{
			return $query->whereIn('status', $variable);
		}
		return $query->where('status', $variable);
	}

	public function scopeActive($query, $variable)
	{
		return $query->whereHas('calendar', function($q){$q;});
	}
}
