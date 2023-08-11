<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HrAttendance extends Model {
	const CREATED_AT = 'con';
	const UPDATED_AT = 'uon';
	protected $table = "hr_attendance";
	protected $fillable = [
		'entry_timestamp', 'exit_timestamp', 'ip', 'pid', 'duration', 'duration_manual',
		'notes', 'exit_manual', 'is_accepted',
		'cby', 'uby',
	];

	public static function getPerPerson($id, $tgl) {
		$tgls = explode('-', $tgl);
		$text = 'select SUM(duration) as durasi, sum(duration_manual) as durasi_manual
            from hr_attendance
            where pid = ' . $id . '
            and year(exit_timestamp) = "' . $tgls[0] . '"
            and month(exit_timestamp) = "' . $tgls[1] . '"
            and day(exit_timestamp) = "' . $tgls[2] . '"
            and exit_manual is null ';
		$return = DB::select($text);
		$return = (count($return) >= 1) ? collect($return[0]) : collect($return);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonTerlambat($id, $tgl) {
		$tgls = explode('-', $tgl);
		$text = 'select SUM(duration) as durasi, sum(duration_manual) as durasi_manual
            from hr_attendance
            where pid = ' . $id . '
            and year(exit_manual) = "' . $tgls[0] . '"
            and month(exit_manual) = "' . $tgls[1] . '"
            and day(exit_manual) = "' . $tgls[2] . '"
            and is_accepted = 1 ';
		$return = DB::select($text);
		$return = (count($return) >= 1) ? collect($return[0]) : collect($return);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonRange($id, $tgl) {
		$text = 'select SUM(duration) as durasi, sum(duration_manual) as durasi_manual
            from hr_attendance
            where pid = ' . $id . '
            AND date(exit_timestamp) BETWEEN "' . $tgl['awal'] . '" AND "' . $tgl['akhir'] . '"
            AND exit_manual is null ';
		$return = DB::select($text);
		$return = (count($return) >= 1) ? collect($return[0]) : collect($return);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonRangeTerlambat($id, $tgl) {
		$text = 'select SUM(duration) as durasi, sum(duration_manual) as durasi_manual
            from hr_attendance
            where pid = ' . $id . '
            AND date(exit_manual) BETWEEN "' . $tgl['awal'] . '" AND "' . $tgl['akhir'] . '"
            AND is_accepted = 1';
		$return = DB::select($text);
		$return = (count($return) >= 1) ? collect($return[0]) : collect($return);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getAll($datas, $datapegawai) {
		$datetime1 = strtotime($datas['tgl_awal']);
		$datetime2 = strtotime($datas['tgl_akhir']);
		$secs = $datetime2 - $datetime1; // == return sec in difference
		$days = $secs / 86400;
		$days = $days + 1;
		$datas['days']['jumlah'] = $days;
		$all = 0;
		$total = array();
		$alldatas = array();
		$datas['days']['detail'] = array();
		for ($i = 0; $i < $days; $i++) {
			$tambahhari = ($i == 0) ? '' : ' +' . $i . ' days';
			$tglbefore = strtotime($datas['tgl_awal'] . $tambahhari);
			$dtglbefore = date('d/m/y', $tglbefore);
			$datas['days']['detail'][$i] = $dtglbefore;
		}
		$datapegawais = array();
		if (count($datas['employe_id']) > 1) {
			if ($datas['employe_id'][0] == '0') {
				unset($datas['employe_id'][0]);
			}
			$datapegawais = $datapegawai->whereIn('id', $datas['employe_id']);
		} else {
			if ($datas['employe_id'][0] == '0') {
				$datapegawais = $datapegawai->all();
			} else {
				$datapegawais = $datapegawai->where('id', $datas['employe_id'][0]);
			}
		}
		$k = 0;
		foreach ($datapegawais as $key => $val) {
			$total[$k] = array('auto' => 0, 'manual' => 0);
			$totals[$k] = array();
			$alldata[$k] = [
                'id' => $val['id'],
                'name' => $val['name'],
                'position' => $val['position'],
                'durasi' => array(), 'total' => $total[$k]
            ];
			for ($i = 0; $i < $days; $i++) {
				$tambahhari = ($i == 0) ? '' : ' +' . $i . ' days';
				$tglbefore = strtotime($datas['tgl_awal'] . $tambahhari);
				$tglnormal = date('Y-m-d', $tglbefore);
				$dtglbefore = date('d/m/y', $tglbefore);
				$komponen = [];
				$datass = array();
				$datasstelat = array();
				if (count($datas['component_id']) > 1) {
					if ($datas['component_id'][0] == '0') {
						unset($datas['component_id'][0]);
					}
					$datass = HrAttendance::getPerPersonComponent($val['id'], $tglnormal, $datas['component_id']);
					$datasstelat = HrAttendance::getPerPersonComponentTerlambat($val['id'], $tglnormal, $datas['component_id']);
					$komponen = HrComponent::whereIn('id', $datas['component_id'])->get();
				} else {
					if ($datas['component_id'][0] == '0') {
						$datass = HrAttendance::getPerPerson($val['id'], $tglnormal);
						$datasstelat = HrAttendance::getPerPersonTerlambat($val['id'], $tglnormal);
						$komponen = array();
					} else {
						$datass = HrAttendance::getPerPersonComponent($val['id'], $tglnormal, $datas['component_id']);
						$datasstelat = HrAttendance::getPerPersonComponentTerlambat($val['id'], $tglnormal, $datas['component_id']);
						$komponen = HrComponent::where('id', $datas['component_id'][0])->get();
					}
				}
				if (empty($komponen)) {
					$alldata[$k]['durasi'][$i]['auto'] = $datass['durasi'];
					$alldata[$k]['durasi'][$i]['auto'] += ($datasstelat['durasi_manual'] * 60);
					$alldata[$k]['durasi'][$i]['manual'] = $datass['durasi_manual'];
					$alldata[$k]['durasi'][$i]['manual'] += $datasstelat['durasi_manual'];
					$total[$k]['auto'] += (int) $alldata[$k]['durasi'][$i]['auto'];
					$total[$k]['manual'] += (int) $alldata[$k]['durasi'][$i]['manual'];
				} else {
					$alldata[$k]['durasi'][$i] = array();
					$total[$k] = array();
					$totalsss = 0;
					for ($x = 0; $x < count($komponen); $x++) {
						$alldata[$k]['durasi'][$i][$x]['name'] = $komponen[$x]['name'];
						$durasikompo = 0;
						if (count($datass) >= 1) {
							for ($xxx = 0; $xxx < count($datass); $xxx++) {
								if ($datass[$xxx]['duty_id'] == $komponen[$x]['id']) {
									$durasikompo = $datass[$xxx]['durasi'];
									$totalsss += (int) $datass[$xxx]['durasi'];
								}
							}
							$total[$k] = $totalsss;
						}
						if (count($datasstelat) >= 1) {
							for ($xxx = 0; $xxx < count($datasstelat); $xxx++) {
								if ($datasstelat[$xxx]['duty_id'] == $komponen[$x]['id']) {
									$durasikompo += $datasstelat[$xxx]['durasi'];
									$totalsss += (int) $datasstelat[$xxx]['durasi'];
								}
							}
							$total[$k] = $totalsss;
						}
						$alldata[$k]['durasi'][$i][$x]['durasi'] = $durasikompo;
					}
				}
			}
			$alldata[$k]['total'] = $total[$k];
			$k++;
		}
		$semuadata = ['datas' => $datas, 'alldata' => $alldata];
		return $semuadata;
	}
	public static function getAllPekananKomponen($datas, $datapegawai) {

		$data = array();
		$bulansblmnya = ($datas['bulan'] == 1) ? 12 : ($datas['bulan'] - 1);
		$tahunsblmnya = ($bulansblmnya == 12) ? ($datas['tahun'] - 1) : $datas['tahun'];
		$jmlhariblnsblmnya = cal_days_in_month(CAL_GREGORIAN, $bulansblmnya, $tahunsblmnya);
		$tglsblmnya = $tahunsblmnya . '-' . ((strlen($bulansblmnya) == 1) ? '0' . $bulansblmnya : $bulansblmnya) . '-28';
		$pekan[0] = $tglsblmnya;
		for ($j = 1; $j < 4; $j++) {
			$pekan[$j] = date('Y-m-d', strtotime('+7 days', strtotime($tglsblmnya)));
			$tglsblmnya = $pekan[$j];
		}
		$pekan[$j] = $datas['tahun'] . '-' . $datas['bulan'] . '-27';
		$tgl['awal'] = $pekan[0];
		$tgl['akhir'] = $pekan[4];
		if ($datas['employe_id'][0] == '0') {
			$datapegawais = $datapegawai->all();
		} else {
			$datapegawais = $datapegawai->whereIn('id', $datas['employe_id'])->toArray();
		}
		$no = 0;
		foreach ($datapegawais as $k => $v) {
			$data[$no]['id'] = $v['id'];
			$data[$no]['nama'] = $v['name'];
			$data[$no]['position'] = $v['position_name'];
			$total = 0;
			$komponen = collect(HrComponent::get())->whereIn('id', $datas['component_id'])->toArray();
			$datakinerja = HrAttendance::getPerPersonComponentRange($v['id'], $tgl, $datas['component_id']);
			$datakinerja = collect($datakinerja);
			$datakinerjalate = HrAttendance::getPerPersonComponentRangeTerlambat($v['id'], $tgl, $datas['component_id']);
			$datakinerjalate = collect($datakinerjalate);
			$noo = 0;
			foreach ($komponen as $kk => $vv) {
				$datakinerjas = $datakinerja->where('duty_id', $vv['id'])->toArray();
				$datakinerjas = reset($datakinerjas);
				$datakinerjaslate = $datakinerjalate->where('duty_id', $vv['id'])->toArray();
				$datakinerjaslate = reset($datakinerjaslate);
				$data[$no]['durasi'][$noo]['name'] = $vv['name'];
				$data[$no]['durasi'][$noo]['desc'] = $vv['desc'];
				$durasiall = (isset($datakinerjas['durasi'])) ? $datakinerjas['durasi'] : '0';
				$durasiall += (isset($datakinerjaslate['durasi'])) ? $datakinerjaslate['durasi'] : '0';
				$data[$no]['durasi'][$noo]['durasi'] = $durasiall;
				$total += (isset($datakinerjas['durasi'])) ? $datakinerjas['durasi'] : 0;
				$noo++;
			}
			$no++;
		}
		return $data;
	}
	public static function getAllPekanan($datas, $datapegawai) {
		$data = array();
		$bulansblmnya = ($datas['bulan'] == 1) ? 12 : ($datas['bulan'] - 1);
		$tahunsblmnya = ($bulansblmnya == 12) ? ($datas['tahun'] - 1) : $datas['tahun'];
		$jmlhariblnsblmnya = cal_days_in_month(CAL_GREGORIAN, $bulansblmnya, $tahunsblmnya);
		$tglsblmnya = $tahunsblmnya . '-' . ((strlen($bulansblmnya) == 1) ? '0' . $bulansblmnya : $bulansblmnya) . '-28';
		$pekan[0] = $tglsblmnya;
		for ($j = 1; $j < 4; $j++) {
			$pekan[$j] = date('Y-m-d', strtotime('+7 days', strtotime($tglsblmnya)));
			$tglsblmnya = $pekan[$j];
		}
		$pekan[$j] = $datas['tahun'] . '-' . $datas['bulan'] . '-27';
		if ($datas['employe_id'][0] == '0') {
			$datapegawais = $datapegawai->all();
		} else {
			$datapegawais = $datapegawai->whereIn('id', $datas['employe_id'])->toArray();
		}
		$no = 0;
		foreach ($datapegawais as $k => $v) {
			$data[$no]['id'] = $v['id'];
			$data[$no]['nama'] = $v['name'];
			$data[$no]['position'] = $v['position_name'];
			$total = 0;
			for ($i = 0; $i < 5; $i++) {
				if ($i == 4) {
					break;
				}
				$tgl['awal'] = $pekan[$i];
				$tgl['akhir'] = date('Y-m-d', strtotime('-1 day', strtotime($pekan[$i + 1])));
				if (count($datas['component_id']) == 1 && $datas['component_id'][0] == '0') {
					$datakinerja = HrAttendance::getPerPersonRange($v['id'], $tgl);
					$data[$no]['durasi'][$i] = $datakinerja['durasi'];
					$datakinerjalate = HrAttendance::getPerPersonRangeTerlambat($v['id'], $tgl);
					$data[$no]['durasi'][$i] += $datakinerjalate['durasi_manual'] * 60;
					$total += $data[$no]['durasi'][$i];
				} else {
					$komponen = collect(HrComponent::get())->whereIn('id', $datas['component_id'])->toArray();
					$datakinerja = HrAttendance::getPerPersonComponentRange($v['id'], $tgl, $datas['component_id']);
					$datakinerja = collect($datakinerja);
					$datakinerjalate = HrAttendance::getPerPersonComponentRangeTerlambat($v['id'], $tgl, $datas['component_id']);
					$datakinerjalate = collect($datakinerjalate);
					$noo = 0;
					foreach ($komponen as $kk => $vv) {
						$datakinerjas = $datakinerja->where('duty_id', $vv['id'])->toArray();
						$datakinerjaslate = $datakinerjalate->where('duty_id', $vv['id'])->toArray();
						$datakinerjaslate = reset($datakinerjas);
						$datakinerjas = reset($datakinerjas);
						$data[$no]['durasi'][$noo][$i]['name'] = $vv['name'];
						$data[$no]['durasi'][$noo][$i]['desc'] = $vv['desc'];
						$durasiall = (isset($datakinerjas['durasi'])) ? $datakinerjas['durasi'] : '0';
						$durasiall += (isset($datakinerjaslate['durasi'])) ? $datakinerjaslate['durasi'] : '0';
						$data[$no]['durasi'][$noo][$i]['durasi'] = $durasiall;
						$total += $durasiall;
						$noo++;
					}
				}
			}
			$data[$no]['total'] = $total;
			$no++;
		}
		return $data;
	}
	public static function getPerPersonComponent($id, $tgl, $com) {
		$tgls = explode('-', $tgl);
		$text = 'SELECT duty_id, NAME, SUM(is_done) AS durasi
            FROM hr_attendance ha
            INNER JOIN hr_attendance_duty AS had ON ha.id = had.`attendance_id`
            INNER JOIN hr_component AS hc ON duty_id = hc.id
            WHERE pid = ' . $id . '
            AND YEAR(exit_timestamp) = "' . $tgls[0] . '"
            AND MONTH(exit_timestamp) = "' . $tgls[1] . '"
            AND DAY(exit_timestamp) = "' . $tgls[2] . '"
            AND duty_id IN (' . implode(',', $com) . ')
            AND exit_manual is null
            GROUP BY duty_id, name';
		$return = DB::select($text);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonComponentTerlambat($id, $tgl, $com) {
		$tgls = explode('-', $tgl);
		$text = 'SELECT duty_id, NAME, SUM(is_done) AS durasi
            FROM hr_attendance ha
            INNER JOIN hr_attendance_duty AS had ON ha.id = had.`attendance_id`
            INNER JOIN hr_component AS hc ON duty_id = hc.id
            WHERE pid = ' . $id . '
            AND YEAR(exit_manual) = "' . $tgls[0] . '"
            AND MONTH(exit_manual) = "' . $tgls[1] . '"
            AND DAY(exit_manual) = "' . $tgls[2] . '"
            AND duty_id IN (' . implode(',', $com) . ')
            AND is_accepted = 1
            GROUP BY duty_id, name';
		$return = DB::select($text);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonComponentRange($id, $tgl, $com) {
		$text = 'SELECT duty_id, NAME, SUM(is_done) AS durasi
            FROM hr_attendance ha
            INNER JOIN hr_attendance_duty AS had ON ha.id = had.`attendance_id`
            INNER JOIN hr_component AS hc ON duty_id = hc.id
            WHERE pid = ' . $id . '
            AND date(exit_timestamp) BETWEEN "' . $tgl['awal'] . '" AND "' . $tgl['akhir'] . '"
            AND duty_id IN (' . implode(',', $com) . ')
            AND exit_manual is null
            GROUP BY duty_id, name';
		$return = DB::select($text);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
	public static function getPerPersonComponentRangeTerlambat($id, $tgl, $com) {
		// $tgls = explode('-',$tgl);
		$text = 'SELECT duty_id, NAME, SUM(is_done) AS durasi
            FROM hr_attendance ha
            INNER JOIN hr_attendance_duty AS had ON ha.id = had.`attendance_id`
            INNER JOIN hr_component AS hc ON duty_id = hc.id
            WHERE pid = ' . $id . '
            AND DATE(exit_manual) BETWEEN "' . $tgl['awal'] . '" AND "' . $tgl['akhir'] . '"
            AND duty_id IN (' . implode(',', $com) . ')
            AND is_accepted = 1
            GROUP BY duty_id, name';
		$return = DB::select($text);
		$return = json_decode(json_encode($return), true);
		return $return;
	}
}
