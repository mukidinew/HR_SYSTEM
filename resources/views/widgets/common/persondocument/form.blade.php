@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
		<h1> {{ is_null($id) ? 'Tambah Dokumen ' : 'Ubah Dokumen '. $DocumentComposer['widget_data']['documentlist']['document']['name']}} "{{$person['name']}}" </h1> 
	@overwrite

	@section('widget_body')	  
		<div class="clearfix">&nbsp;</div>
		{!! Form::open(['url' => $DocumentComposer['widget_data']['documentlist']['form_url'], 'class' => 'form no_enter']) !!}	
			@foreach($DocumentComposer['widget_data']['documentlist']['document']['templates'] as $key => $value)
				<div class="form-group">
					<label for="field" class="control-label">{{ucwords($value['field'])}}</label>					
					<?php 
						$content = null;
						$detailid = null;
						if($persondocument['details'])
						{
							foreach ($persondocument['details'] as $key2 => $value2) 
							{
								if($value['id']==$value2['template_id'] && $value['type']=='date')
								{
									$detailid = $value2['id'];
									$content = $value2['on'];
								}
								elseif($value['id']==$value2['template_id'])
								{
									$detailid = $value2['id'];
									$content = $value2[$value['type']];
								}
							}
						}

						switch (strtolower($value['type'])) 
						{
							case 'text':
								$form 		= '<textarea name="content['.$key.']" value="" class="form-control" tabindex="'.($key+1).'">'.$content.'</textarea>';
								break;
							case 'date':
								$form 		= '<input type="date" class="form-control date-mask" id="text" name="content['.$key.']" value="'.$content.'" tabindex="'.($key+1).'">';
								break;
							case 'numeric':
								$form 		= '<input type="numeric" class="form-control" id="text" name="content['.$key.']" value="'.$content.'" tabindex="'.($key+1).'">';
								break;
							default:
								$form 		= '<input type="text" class="form-control" id="text" name="content['.$key.']" value="'.$content.'" tabindex="'.($key+1).'">';
								break;
						}
					;?>					
					{!!$form!!}					
					<input type="hidden" class="form-control" id="text" name="template_id[{{$key}}]" value="{{$value['id']}}">
					<input type="hidden" class="form-control" id="text" name="detail_id[{{$key}}]" value="{{$detailid}}">
				</div>
			@endforeach
			<div class="form-group text-right">				
				<a href="{{ $DocumentComposer['widget_data']['documentlist']['route_back'] }}" class="btn btn-default mr-5" tabindex="15">Batal</a>
				<input type="submit" class="btn btn-primary" value="Simpan" tabindex="14">				
			</div>
		{!! Form::close() !!}
	@overwrite	
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif