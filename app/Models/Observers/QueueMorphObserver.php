<?php namespace App\Models\Observers;

use DB, Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving						
 * ---------------------------------------------------------------------- */

class QueueMorphObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			return true;
		}
		else
		{
			$model['errors'] 	= $validator->errors();

			return false;
		}
	}
}
