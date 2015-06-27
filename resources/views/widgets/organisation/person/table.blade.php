@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
	<h1> {!! $widget_title  or 'Data Karyawan' !!} </h1>
	<small>Total data {{$PersonComposer['widget_data']['personlist']['person-pagination']->total()}}</small>
	@overwrite

	@section('widget_body')
		<a href="{{ $PersonComposer['widget_data']['personlist']['route_create'] }}" class="btn btn-primary">Tambah Data</a>
		@if(isset($PersonComposer['widget_data']['personlist']['person']))
			<div class="clearfix">&nbsp;</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="row">
							<th class="col-sm-2">Nama</th>
							<th class="col-sm-4">Posisi</th>
							<th class="col-sm-2">Email</th>
							<th class="col-sm-4">&nbsp;</th>
						</tr>
					</thead>
					@foreach($PersonComposer['widget_data']['personlist']['person'] as $key => $value)
						<tbody>
							<tr class="row">
								<td class="col-sm-2">
									{{$value['name']}}
								</td>
								<td class="col-sm-4">
									{{$value['works'][0]['name']}} departemen {{$value['works'][0]['tag']}} cabang {{$value['works'][0]['branch']['name']}}
								</td>
								<td class="col-sm-2">
									{{$value['contacts'][0]['value']}}
								</td>
								<td class="text-right col-sm-4">
									<a href="javascript:;" class="btn btn-default" data-toggle="modal" data-target="#delete" data-delete-action="{{ route('hr.persons.delete', [$value['id'], 'org_id' => $data['id']]) }}"><i class="fa fa-trash"></i></a>
									<a href="{{route('hr.persons.edit', [$value['id'], 'org_id' => $data['id']])}}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
									<a href="{{route('hr.persons.show', [$value['id'], 'org_id' => $data['id']])}}" class="btn btn-default"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
						</tbody>
					@endforeach
				</table>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<p>Menampilkan {!!$PersonComposer['widget_data']['personlist']['person-display']['from']!!} - {!!$PersonComposer['widget_data']['personlist']['person-display']['to']!!}</p>
					{!!$PersonComposer['widget_data']['personlist']['person-pagination']->appends(Input::all())->render()!!}
				</div>
			</div>

			<div class="clearfix">&nbsp;</div>
		@endif
	@overwrite
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif