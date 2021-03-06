<html>
<body>
	@if(isset($data))
		<table class="table">
			<thead>
				<tr>
					<th colspan="18"></th>
				</tr>
				<tr>
					<th style="width:10%">&nbsp;</th>
					<th colspan="17" style="height:20%">Laporan Kehadiran Per Tanggal {{$start}} - {{$end}} Unit Bisnis {{$org['name']}}</th>
				</tr>
				<tr>
					<th colspan="18"></th>
				</tr>
				<tr>
					<th style="width:10%">&nbsp;</th>
					<th rowspan="2" style="width:4%; height:25%">No<br/>&nbsp;</th>
					<th rowspan="2" style="width:30%; height:25%">Nama <br/>(Jabatan)</th>
					<th rowspan="2" style="width:25%; height:25%">Tanggal</th>
					<th rowspan="2" style="text-align:center; width:4%; height:25%">HB</th>
					<th colspan="4" style="text-align:center; width:16%; height:25%">HC</th>
					<th colspan="8" style="text-align:center; width:32%; height:25%">AS</th>
					<th rowspan="2" style="width:6%; height:25%">Total</th>
					<th rowspan="2" style="width:8%; height:25%">Time &nbsp; Loss &nbsp; Rate</th>
				</tr>
				<tr>
					<th style="width:10%">&nbsp;</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th style="text-align:center; width:4%; height:25%">HT</th>
					<th style="text-align:center; width:4%; height:25%">HP</th>
					<th style="text-align:center; width:4%; height:25%">HD</th>
					<th style="text-align:center; width:4%; height:25%">HC</th>
					<th style="text-align:center; width:4%; height:25%">DN</th>
					<th style="text-align:center; width:4%; height:25%">SS</th>
					<th style="text-align:center; width:4%; height:25%">SL</th>
					<th style="text-align:center; width:4%; height:25%">CN</th>
					<th style="text-align:center; width:4%; height:25%">CB</th>
					<th style="text-align:center; width:4%; height:25%">CI</th>
					<th style="text-align:center; width:4%; height:25%">UL</th>
					<th style="text-align:center; width:4%; height:25%">AS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $key => $value)
					<tr>
						<td style="width:10%">&nbsp;</td>
						<td style="text-align:center; width:4%; height:35%">{{$key+1}}</td>
						<td style="text-align:center; width:30%; height:35%">
							{{$value['name']}}<br/>&nbsp;
							@if($value['position']!='')
								({{$value['position']}} {{$value['department']}} {{$value['branch']}})
							@elseif(isset($value['works'][0]))
								({{$value['works'][0]['name']}} {{$value['works'][0]['tag']}} {{$value['works'][0]['branch']['name']}})
							@endif
						</td>
						<td style="text-align:center; width:30%; height:35%">
							{{ date('d-m-Y', strtotime($value['created_at'])) }}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['HB']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['HT']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['HP']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['HD']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['HC']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['DN']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['SS']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['SL']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['CN']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['CB']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['CI']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['UL']}}
						</td>
						<td style="text-align:center; width:4%; height:35%">
							{{$value['AS']}}
						</td>
						<td style="text-align:center; width:6%; height:35%">
							{{$value['HB']+$value['HT']+$value['HP']+$value['HD']+$value['HC']+$value['DN']+$value['SS']+$value['SL']+$value['CN']+$value['CB']+$value['CI']+$value['UL']+$value['AS']}}
						</td>
						<td style="text-align:center; width:8%; height:35%">
							@if($value['position']!='')
								<?php $tlr = ($value['total_absence']!=0 ? $value['total_absence'] : 1) / ($value['possible_total_effective']!=0 ? $value['possible_total_effective'] : 1);?>
								{{(round(abs($tlr) * 100, 2) <= 100 ? round(abs($tlr) * 100, 2) : 100 )}} %
							@else
								100 %
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	@endif
</body>
</html>