<?php namespace App\Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving						
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class MaritalStatusObserver 
{
	public function saving($model)
	{
		$validator 					= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			return true;
		}
		else
		{
			$model['errors'] 		= $validator->errors();

			return false;
		}
	}

	public function deleting($model)
	{
		//
	}
}