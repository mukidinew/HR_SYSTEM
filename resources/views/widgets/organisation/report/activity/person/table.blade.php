<?php
	ini_set('xdebug.max_nesting_level', 200);
?>
@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
	<h1> {!! $widget_title or 'Laporan Akivitas' !!} </h1>
	<small>Total data {{ count($PersonComposer['widget_data']['personlist']['person']['processlogs']) }}</small>
	
	<div class="btn-group pull-right">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-file"></i> Export to <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="{{route('hr.report.activities.show', array_merge([$person['id'],'print' => 'yes', 'mode' => 'csv'], Input::all()))}}">CSV</a></li>
			<li><a href="{{route('hr.report.activities.show', array_merge([$person['id'],'print' => 'yes', 'mode' => 'xls'], Input::all()))}}">XLS</a></li>
		</ul>
	</div>
	@overwrite

	@section('widget_body')
		@if(isset($PersonComposer['widget_data']['personlist']['person']['processlogs']))
			<table class="table table-affix">
				<thead>
					<tr>
						<th rowspan="2" class="text-center font-11" style="width:4%">No<br/>&nbsp;</th>
						<th rowspan="2" class="text-left font-11">Tanggal<br/>&nbsp;</th>
						<th rowspan="2" class="text-center font-11">Total Aktif<br/>&nbsp;</th>
						<th rowspan="2" class="text-center font-11">Total Idle I <br/>(Freq)</th>
						<th rowspan="2" class="text-center font-11">Total Idle II <br/>(Freq)</th>
						<th rowspan="2" class="text-center font-11">Total Idle III <br/>(Freq)</th>
						<th rowspan="2">&nbsp;</th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					@foreach($PersonComposer['widget_data']['personlist']['person']['processlogs'] as $key => $value)
						<tr>
							<td class="font-11">
								{{$key+1}}
							</td>
							<td class="font-11">
								{{ date('d-m-Y', strtotime($value['on'])) }}
							</td>
							@if(isset($value['idlelogs'][0]))
								<td class="font-11 text-center">
									{{floor(($value['idlelogs'][0]['total_active'])/3600)}} Jam<br/>
									{{floor((($value['idlelogs'][0]['total_active'])%3600)/60)}} Menit<br/> 
								</td>
								<td class="font-11 text-center">
									{{floor($value['idlelogs'][0]['total_idle_1']/3600)}} Jam<br/>
									{{floor(($value['idlelogs'][0]['total_idle_1']%3600)/60)}} Menit<br/> 
									({{$value['idlelogs'][0]['frequency_idle_1']}})
								</td>
								<td class="font-11 text-center">
									{{floor($value['idlelogs'][0]['total_idle_2']/3600)}} Jam<br/>
									{{floor(($value['idlelogs'][0]['total_idle_2']%3600)/60)}} Menit<br/> 
									({{$value['idlelogs'][0]['frequency_idle_2']}})
								</td>
								<td class="font-11 text-center">
									{{floor($value['idlelogs'][0]['total_idle_3']/3600)}} Jam<br/>
									{{floor(($value['idlelogs'][0]['total_idle_3']%3600)/60)}} Menit<br/> 
									({{$value['idlelogs'][0]['frequency_idle_3']}})
								</td>
							@else
								<td class="font-11 text-center"></td>
								<td class="font-11 text-center"></td>
								<td class="font-11 text-center"></td>
								<td class="font-11 text-center"></td>
							@endif
							<td class="text-right font-11">
								<a href="{{route('hr.activity.logs.index', ['person_id' => $value['person_id'], 'org_id' => $data['id'], 'start' => $start, 'end' => $end, 'ondate' => $value['on']])}}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
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