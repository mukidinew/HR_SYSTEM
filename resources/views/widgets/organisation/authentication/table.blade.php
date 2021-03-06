@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
		<h1> {!! $widget_title  or 'Otentikasi' !!} </h1>
		<small>Total data {{$WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-pagination']->total()}}</small>
		
		<?php
			$WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-pagination']->setPath(route('hr.authentications.index'));
		?>
	@overwrite

	@section('widget_body')
		@if((int)Session::get('user.menuid')<=4)
			<a href="{{ $WorkAuthenticationComposer['widget_data']['workauthlist']['route_create'] }}" class="btn btn-primary">Tambah Data</a>
		@endif
		<div class="clearfix">&nbsp;</div>
		<table class="table table-hover table-affix">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Level</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $i = $WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-display']['from'];?>
				@forelse($WorkAuthenticationComposer['widget_data']['workauthlist']['workauth'] as $key => $value)
					<tr>
						<td>{{$i}}</td>
						<td>{{$value['work']['person']['name']}}</td>
						<td>{{$value['authgroup']['name']}}</td>
						<td class="text-right">
							@if((int)Session::get('user.menuid') <= 2)
								<a href="javascript:;" class="btn btn-default" data-toggle="modal" data-target="#delete" data-delete-action="{{ route('hr.authentications.delete', [$value['id'], 'org_id' => $data['id']]) }}" title="hapus"><i class="fa fa-trash fa-fw"></i></a>
							@endif
						</td>
					</tr>
					<?php $i++;?>
				@empty 
					<tr>
						<td class="text-center" colspan="4">Tidak ada data</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		<div class="row">
			<div class="col-sm-12 text-center">
				<p>Menampilkan {!!$WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-display']['from']!!} - {!!$WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-display']['to']!!}</p>
				{!!$WorkAuthenticationComposer['widget_data']['workauthlist']['workauth-pagination']->appends(Input::all())->render()!!}
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
	@overwrite
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif