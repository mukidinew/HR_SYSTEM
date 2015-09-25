<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Models\AttendanceDetail;
use App\Models\AttendanceLog;
use App\Models\IdleLog;
use App\Models\ProcessLog;
use App\Models\Log;
use App\Models\ErrorLog;
use App\Models\RecordLog;
use App\Models\QueueMorph;
use App\Models\Queue;
use App\Models\PersonWorkleave;
use App\Models\PersonDocument;
use App\Models\Organisation;
use DB;

class HRResetTableCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'hr:resettable';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command Reset Table Log.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		if(isset($this->option()['orgcode']))
		{
			$id 			= $this->option()['orgcode'];

			$org 			= Organisation::code($id)->first();

			if($org)
			{
				$result 		= $this->emptytable($id);
			}
			else
			{
				$this->info("invalid code");
			}
		}
		else
		{
			$this->info("no orgcode");
		}

		return true;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['orgcode', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
            array('orgcode', null, InputOption::VALUE_OPTIONAL, 'Queue ID', null),
        );
	}

	/**
	 * EMPTY TABLE
	 *
	 * @return void
	 * @author 
	 **/
	public function emptytable($orgcode)
	{
		$attendance_details 		= AttendanceDetail::whereHas('attendancelog.processlog.person.organisation', function($q)use($orgcode){$q->code($orgcode);})->get();

		foreach ($attendance_details as $key => $value) 
		{
			if($value->person_workleave_id!=0)
			{
				$pwleave 				= PersonWorkleave::find($value->person_workleave_id);
				if(!$pwleave->delete())
				{
					$this->info($value->errors);
				}
			}
			
			if($value->person_document_id!=0)
			{
				$pdoc 					= PersonDocument::find($value->person_document_id);
				if(!$pdoc->delete())
				{
					$this->info($value->errors);
				}
			}
		}

		$attendance_details 		= AttendanceDetail::whereHas('attendancelog.processlog.person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Attendance Details for ".$orgcode);

		$alogs 						= AttendanceLog::whereHas('processlog.person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();
		
		$this->info("Truncate Attendance Logs for ".$orgcode);

		$ilogs 						= IdleLog::whereHas('processlog.person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Idle Logs for ".$orgcode);

		$plogs 						= ProcessLog::whereHas('person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Process Logs for ".$orgcode);

		$logs 						= Log::whereHas('person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Logs for ".$orgcode);

		$elogs 						= ErrorLog::whereHas('organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Error Logs for ".$orgcode);

		$rlogs 						= RecordLog::whereHas('person.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Record Logs for ".$orgcode);

		$queuesM 					= QueueMorph::whereHas('queue.createdby.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Queues Morph for ".$orgcode);

		$queues 					= Queue::whereHas('createdby.organisation', function($q)use($orgcode){$q->code($orgcode);})->delete();

		$this->info("Truncate Queues for ".$orgcode);

		return true;
	}

}
