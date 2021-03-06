<?php namespace App\Models;

/* ----------------------------------------------------------------------
 * Document Model:
 * 	ID 								: Auto Increment, Integer, PK
 * 	branch_id 						: Required, Integer, FK from Branch
 * 	chart_id 						: Required, Integer, FK from Chart
 * 	path 							: Varchar, 255, Required
 * 	tag 							: Varchar, 255, Required
 * 	name 							: Varchar, 255, Required
 * 	min_employee  					: Integer, Required
 * 	ideal_employee  				: Integer, Required
 * 	max_employee  					: Integer, Required
 * 	max_employee  					: Integer
 * 	current_employee				: Integer
 *	created_at						: Timestamp
 * 	updated_at						: Timestamp
 * 	deleted_at						: Timestamp
 * 
/* ----------------------------------------------------------------------
 * Document Relationship :
 * 	//this package
 	1 Relationship hasMany 
	{
		Charts
	}

 	2 Relationships belongsTo 
	{
		Branch
		Chart
	}

 * 	//other package
 	3 Relationships belongsToMany 
	{
		Works
		Menus
		Calendars
	}

	1 Relationship hasMany 
	{
		Workleaves
	}

 * ---------------------------------------------------------------------- */

use Illuminate\Database\Eloquent\SoftDeletes;
use Str, Validator, DateTime, Exception;

class Chart extends BaseModel {

	use SoftDeletes;
	use \App\Models\Traits\BelongsTo\HasBranchTrait;
	use \App\Models\Traits\HasMany\HasChartsTrait;
	use \App\Models\Traits\HasMany\HasWorkleavesTrait;
	use \App\Models\Traits\BelongsTo\HasChartTrait;
	use \App\Models\Traits\BelongsToMany\HasWorksTrait;
	use \App\Models\Traits\BelongsToMany\HasMenusTrait;
	use \App\Models\Traits\BelongsToMany\HasFollowCalendarsTrait;

	public 		$timestamps 		= 	true;

	protected 	$table 				= 	'charts';

	protected 	$fillable			= 	[
											'chart_id'				,
											'path'					,
											'name' 					,
											'tag' 					,
											'min_employee' 			,
											'ideal_employee' 		,
											'max_employee' 			,
											'current_employee' 		,
										];

	protected 	$rules				= 	[
											'path'		 			=> 'max:255',
											'name' 					=> 'required|max:255',
											'tag' 					=> 'required|max:255',
											'min_employee' 			=> 'required|numeric|min:1',
											'ideal_employee' 		=> 'required|numeric',
											'max_employee' 			=> 'required|numeric',
											'current_employee' 		=> 'numeric',
										];

	public $searchable 				= 	[
											'id' 					=> 'ID', 
											'branchid'		 		=> 'BranchID',
											'organisationid'		=> 'OrganisationID',

											'name' 					=> 'Name', 
											'orname' 				=> 'OrName', 
											'notadmin' 				=> 'NotAdmin', 
											'tag' 					=> 'Tag', 
											'ortag' 				=> 'OrTag', 
											'child' 				=> 'Child', 
											'neighbor' 				=> 'Neighbor', 
											'grouptag'	 			=> 'GroupTag',

											'orbranchname' 			=> 'OrBranchName', 
											'withattributes' 		=> 'WithAttributes',
											'withtrashed' 			=> 'WithTrashed',
										];

	public $searchableScope 		= 	[
											'id' 					=> 'Could be array or integer', 
											'branchid'		 		=> 'Could be array or integer',
											'organisationid'		=> 'Could be array or integer',

											'name' 					=> 'Must be string', 
											'orname' 				=> 'Could be array or string', 
											'tag' 					=> 'Must be string', 
											'ortag' 				=> 'Could be array or string', 
											'child' 				=> 'Path of current node', 
											'neighbor' 				=> 'Path of current node', 
											'grouptag'	 			=> 'Null',
											'notadmin'	 			=> 'Null',

											'orbranchname' 			=> 'Could be array or string', 
											'withattributes' 		=> 'Must be array of relationship',
											'withtrashed' 			=> 'Must be true',
										];

	public $sortable 				= 	['id', 'name', 'created_at', 'path', 'charts.name'];

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

	/* ---------------------------------------------------------------------------- ERRORS ----------------------------------------------------------------------------*/
	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	function getError()
	{
		return $this->errors;
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
			return $query->whereIn('charts.id', $variable);
		}
		return $query->where('charts.id', $variable);
	}
	

	public function scopeOrName($query, $variable)
	{
		if(is_array($variable))
		{
			foreach ($variable as $key => $value) 
			{
				$query 		= $query->orwhere('charts.name', 'like' ,'%'.$value.'%');
			}

			return $query;
		}
		return $query->orwhere('charts.name', 'like' ,'%'.$variable.'%');
	}

	public function scopeName($query, $variable)
	{
		return $query->where('name', 'like' ,'%'.$variable.'%');
	}

	public function scopeNotAdmin($query, $variable)
	{
		return $query->where('name', '<>', 'system admin')->where('tag', '<>', 'admin');
	}

	public function scopeTag($query, $variable)
	{
		return $query->where('tag', $variable);
	}

	public function scopeChild($query, $variable)
	{
		if(is_array($variable))
		{
			return $query->where(function($q)use($variable){$q->where('path', 'like', $variable[0].'%')->orwhere('charts.id', $variable[1]);});
		}

		return $query->where('path', 'like', $variable.'%');
	}

	public function scopeNeighbor($query, $variable)
	{
		return $query->where('path', 'not like', $variable.'%');
	}

	public function scopeOrTag($query, $variable)
	{
		if(is_array($variable))
		{
			foreach ($variable as $key => $value) 
			{
				$query 		= $query->orwhere('tag', 'like' ,'%'.$value.'%');
			}

			return $query;
		}

		return $query->orwhere('tag', 'like' ,'%'.$variable.'%');
	}

	public function scopeGroupTag($query, $variable)
	{
		return $query->groupby('tag');
	}

}
