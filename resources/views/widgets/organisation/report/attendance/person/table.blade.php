@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
	<h1> {!! $widget_title or 'Laporan Akivitas' !!} </h1>
	<small>Total data {{ count($PersonComposer['widget_data']['personlist']['person']['processlogs']) }}</small>
	@overwrite

	@section('widget_body')
			@if(isset($PersonComposer['widget_data']['personlist']['person']['processlogs']))
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							
							<th>Time Loss Rate</th>
							<th>Status Awal</th>
							<th>Status Modifikasi</th>
							<th>Dimodifikasi Oleh</th>
							<th>Dimodifikasi Tanggal</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					@foreach($PersonComposer['widget_data']['personlist']['person']['processlogs'] as $key => $value)
						<tbody>
							<tr>
								<td>
									{{$key+1}}
								</td>
								<td>
									@date_indo($value['on'])
								</td>
								<td>
									<?php
										$margin_start = 0;
										$margin_end = 0;
										if(in_array($value['modified_status'], ['HC', 'AS', 'UL', 'SS', 'LL']) || in_array($value['actual_status'], ['HC', 'AS']))
										{
											if($value['margin_start']<0)
											{
												$margin_start=abs($value['margin_start']);
											}
											if($value['margin_end']<0)
											{
												$margin_end=abs($value['margin_end']);
											}
										}

										$total_absence = $margin_end + $margin_start;

										list($hours, $minutes, $seconds) = explode(":", $value['schedule_end']);

										$schedule_end_second	= $hours*3600+$minutes*60+$seconds;

										list($hours, $minutes, $seconds) = explode(":", $value['schedule_start']);

										$schedule_start_second	= $hours*3600+$minutes*60+$seconds;

										$tlr = ($total_absence!=0 ? $total_absence : 1) / (abs($schedule_end_second - $schedule_start_second)!=0 ? abs($schedule_end_second - $schedule_start_second) : 1);?>
									{{round(abs($tlr) * 100, 2)}} %
								</td>

								<td>
									{{$value['actual_status']}}
								</td>
								<td>
									{{($value['modified_status']!='' ? $value['modified_status'] : '')}}
								</td>
								<td>
									{{($value['modified_status']!='' ? $value['modifiedby']['name'] : '')}}
								</td>
								<td>
									@if($value['modified_status']!='')
										@date_indo($value['modified_at'])
									@endif
								</td>
								<td class="text-right">
									<a href="{{route('hr.attendance.persons.edit', ['id' => $value['id'], 'person_id' => $person['id'], 'org_id' => $data['id']])}}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
									<a href="{{route('hr.attendance.persons.show', ['id' => $person['id'], 'person_id' => $person['id'], 'org_id' => $data['id'], 'ondate' => $value['on']])}}" class="btn btn-default"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
						</tbody>
					@endforeach
				</table>

				<div class="clearfix">&nbsp;</div>
			@endif
	@overwrite	
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif