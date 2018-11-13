<?php
	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = substr($tgl,5,2);
			$tahun = substr($tgl,0,4);
			$jam = substr($tgl,11,8);
			return $tanggal.'-'.$bulan.'-'.$tahun.' '.$jam;		 
	}	

?>
