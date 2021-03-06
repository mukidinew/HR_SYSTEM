@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@section('widget_body')
	<div class="modal fade delete" id="{{ (isset($modal) ? $modal : 'delete') }}" tabindex="-1" role="dialog" aria-labelledby="Hapus" aria-hidden="true">
		<div class="modal-dialog form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title text-xl " id="formModalLabel">Hapus Data</h4>
				</div>
				<div class="modal-body" style="background-color:#f5f5f5">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="text-danger">Perhatian</h4>
							<article class="margin-bottom-xxl">
								<p class="opacity-75">
									Apakah Anda yakin akan menghapus data? Silahkan masukkan password Anda untuk konfirmasi.
								</p>
							</article>
						</div>
					</div>
					<div class="row mt-20 mb-20">
						<div class="form-group">
							<div class="col-sm-3">
								<label for="password" class="control-label">Password</label>
							</div>
							<div class="col-sm-9">
								<input type="password" name="password" id="password" class="form-control input-delete" placeholder="Password" autofocus>
							</div>
						</div>
						<div class="modal_delete_affect_org"></div>
					</div>
				</div>
				<div class="modal-footer bg-grey">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</div>
		</div>
	</div>
@overwrite
