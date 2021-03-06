@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@section('widget_body')
	<div class="modal fade {{ isset($class_id) ? $class_id : '' }}" id="{{ isset($class_id) ? $class_id : '' }}" tabindex="-1" role="dialog" aria-labelledby="Import CSV" aria-hidden="true">
		<div class="modal-dialog form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title text-xl " id="formModalLabel">Tambah Widget</h4>
				</div>
				<div class="modal-body" style="background-color:#f5f5f5">
					<div class="row mb-20">
						<div class="col-lg-12">
							<h4 class="text-primary">Petunjuk</h4>
							<article class="margin-bottom-xxl">
								<p class="opacity-75">
									Silahkan menambah widget sesuai pilihan anda.
								</p>
							</article>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Title</label>
								{!! Form::input('text', 'title', '', ['class' => 'form-control', 'placeholder' => 'Title Widget', 'tabindex' => '1']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Tipe Dashboard Widget</label>
								<select name="dashboard" class="form-control select_type_widget" tabindex="2">
									@if (Session::get('user.menuid')<=3) <option value="organisation">Organisasi</option> @endif
									<option value="person">Karyawan</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Data</label>
								{{-- Organisation Widget --}}
								@if (Session::get('user.menuid')<=3)
									<select name="data_widget_org" id="select2-dashboard-widget" class="form-control select_widget_org" tabindex="3">
										<option value="processlogondate" data-type="table" data-widget-option-title="Table SP Print" data-template="widgets.common.personwidget.table.table_sp" data-query="sp">
											SP Print list
										</option>
										<option value="processlogondate" data-type="table" data-widget-option-title="Table Idle Terbanyak" data-template="widgets.common.personwidget.table.table_idle" data-query="idle">
											Idle Terbanyak
										</option>
										<option value="fullschedule" data-type="table" data-widget-option-title="Table Karyawan" data-template="widgets.common.personwidget.table.table_person" data-query="person">
											Daftar Karyawan
										</option>
										<option value="ondate" data-type="table" data-widget-option-title="Table Karyawan Sedang Cuti" data-template="widgets.common.personwidget.table.table_workleave" data-query="workleave">
											Karyawan Yang Sedang Cuti
										</option>
										<option value="" data-type="stat" data-widget-option-title="Total Cabang" data-template="widgets.common.personwidget.stat.stat_branch" data-query="branch">
											Total Cabang
										</option>
										<option value="" data-type="stat" data-widget-option-title="Total Dokumen" data-template="widgets.common.personwidget.stat.stat_document" data-query="document">
											Total Dokumen
										</option>
										<option value="totalprocesslogondate" data-type="stat" data-widget-option-title="Total Idle Terbanyak" data-template="widgets.common.personwidget.stat.stat_idle" data-query="idle">
											Total Idle
										</option>
										<option value="chartnotadmin" data-type="stat" data-widget-option-title="Total Karyawan" data-template="widgets.common.personwidget.stat.stat_person" data-query="person">
											Total Karyawan
										</option>
										<option value="totalprocesslogondate" data-type="stat" data-status="as" data-widget-option-title="Total Karyawan Status AS Terbanyak" data-template="widgets.common.personwidget.stat.stat_status" data-query="state">
											Total Karyawan Status AS Terbanyak
										</option>
										<option value="totalprocesslogondate" data-type="stat" data-status="hb" data-widget-option-title="Total Karyawan Status HB Terbanyak" data-template="widgets.common.personwidget.stat.stat_status" data-query="state">
											Total Karyawan Status HB Terbanyak
										</option>
										<option value="totalprocesslogondate" data-type="stat" data-status="hc" data-widget-option-title="Total Karayawan Status HC Terbanyak" data-template="widgets.common.personwidget.stat.stat_status" data-query="state">
											Total Karyawan Status HC Terbanyak
										</option>
										<option value="totalondate" data-type="stat" data-widget-option-title="Total Karyawan Sedang Cuti" data-template="widgets.common.personwidget.stat.stat_workleave" data-query="workleave">
											Total Karyawan Yang Sedang Cuti
										</option>
										<option value="globalattendance" data-type="stat" data-widget-option-title="Total Dokumen" data-template="widgets.common.personwidget.stat.stat_lossrate" data-query="lossrate">
											Total Loss Rate
										</option>
									</select>
								@endif

								{{-- Person Widget --}}
								<select name="data_widget_person" id="" class="form-control select_widget_person @if (Session::get('user.menuid')<=3) hide @endif" tabindex="4">
									<option value="" data-type="table" data-widget-option-title="Daftar Pekerjaan" data-template="widgets.common.personwidget.table.table_work" data-query="work">
										Daftar Pekerjaan
									</option>
									<option value="globalworkleave" data-type="stat" data-widget-option-title="Sisa Cuti" data-template="widgets.common.personwidget.stat.stat_leftquota" data-query="leftquota">
										Sisa Cuti
									</option>
									<option value="processlogondate" data-type="table" data-widget-option-title="Daftar SP" data-template="widgets.common.personwidget.table.table_sp" data-query="sp">
										SP
									</option>
									<option value="totalprocesslogondate" data-type="stat" data-widget-option-title="Total Aktif" data-template="widgets.common.personwidget.stat.stat_active" data-query="active">
										Total Aktif
									</option>
									<option value="totalprocesslogondate" data-type="stat" data-widget-option-title="Total Idle" data-template="widgets.common.personwidget.stat.stat_idle" data-query="idle">
										Total Idle
									</option>
									<option value="globalattendance" data-type="stat" data-widget-option-title="Total Loss Rate" data-template="widgets.common.personwidget.stat.stat_lossrate" data-query="lossrate">
										Total Loss Rate
									</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Periode</label>
								<select name="periode" class="form-control select2" tabindex="5">
									<option value="today">Hari Ini</option>
									<option value="this week">Minggu Ini</option>
									<option value="this month">Bulan Ini</option>
									<option value="this year">Tahun Ini</option>
									<option value="tomorrow">1 Hari Sebelum</option>
									<option value="- 2 days">2 Hari Sebelum</option>
									<option value="- 3 days">3 Hari Sebelum</option>
									<option value="- 4 days">4 Hari Sebelum</option>
									<option value="- 5 days">5 Hari Sebelum</option>
									<option value="- 6 days">6 Hari Sebelum</option>
									<option value="- a week">Seminggu Sebelum</option>
									<option value="- 2 weeks">2 Minggu Sebelum</option>
									<option value="- 3 weeks">3 Minggu Sebelum </option>
									<option value="- a month">1 Bulan Sebelum</option>
									<option value="- 2 months">2 Bulan Sebelum</option>
									<option value="- 3 months">3 Bulan Sebelum</option>
									<option value="- 4 months">4 Bulan Sebelum</option>
									<option value="- 5 months">5 Bulan Sebelum</option>
									<option value="yesterday">1 Hari Sesudah</option>
									<option value="+ 2 days">2 Hari Sesudah</option>
									<option value="+ 3 days">3 Hari Sesudah</option>
									<option value="+ 4 days">4 Hari Sesudah</option>
									<option value="+ 5 days">5 Hari Sesudah</option>
									<option value="+ 6 days">6 Hari Sesudah</option>
									<option value="+ a week">Seminggu Sesudah</option>
									<option value="+ 2 weeks">2 Minggu Sesudah</option>
									<option value="+ 3 weeks">3 Minggu Sesudah </option>
									<option value="+ a month">1 Bulan Sesudah</option>
									<option value="+ 2 months">2 Bulan Sesudah</option>
									<option value="+ 3 months">3 Bulan Sesudah</option>
									<option value="+ 4 months">4 Bulan Sesudah</option>
									<option value="+ 5 months">5 Bulan Sesudah</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<div class="checkbox">
									<label>
										{!!Form::checkbox('is_active', '1', '', ['class' => '', 'tabindex' => '6'])!!} Aktif
									</label>
								</div>				
							</div>
						</div>
					</div>
					{{-- <div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Urutkan</label>
								<select name="sort" class="form-control">
									<option value="">Pilih</option>
									<option value="asc">Dari </option>
									<option value="desc">DESC</option>
								</select>
							</div>
						</div>
					</div>			 --}}
				</div>
				{!! Form::hidden('org_id', '', ['class' => 'hid_org_id']) !!}
				{!! Form::hidden('type', 'table', ['class' => 'type_widget']) !!}
				{!! Form::hidden('status', '', ['class' => 'processlog_status']) !!}
				{!! Form::hidden('widget_option_title', 'Table SP', ['class' => 'widget_option_title']) !!}
				{!! Form::hidden('widget_template', 'widgets.common.personwidget.table.table_sp', ['class' => 'widget_template']) !!}
				{!! Form::hidden('widget_data', 'processlogondate', ['class' => 'widget_data']) !!}
				{!! Form::hidden('widget_query', 'sp', ['class' => 'widget_query']) !!}
				<div class="modal-footer bg-grey">
					<button type="button" class="btn btn-default" data-dismiss="modal" tabindex="8">Batal</button>
					<button type="submit" class="btn btn-primary" tabindex="7">Tambah</button>
				</div>
			</div>
		</div>
	</div>
@overwrite