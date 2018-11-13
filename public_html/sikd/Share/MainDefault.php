<?php
if($_SESSION["menu"] == "admin"){
	$pnlAdmin = "inline";
	$pnlUser = "none";
}else{
	$pnlAdmin = "none";
	$pblUser = "inline";
}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Petunjuk Umum';
</script>
<div style="width: auto;">
	<table>
    <tr>
        <td style="width:2%;">&nbsp;
        </td>
        <td style="width:98%; vertical-align:top">
            <table style="width:100%;">
                <tr>
                    <td style="width:100%;">
                        <div id="pnlUser" style="display:<? echo $pnlUser; ?>">
                            <ul>
                                <li>Menu Registrasi Surat untuk melakukan Registrasi Surat Masuk dan Surat Keluar</li>
                                <li>Menu Surat Masuk untuk melihat Surat Masuk</li>
								<li>Menu Log Surat Keluar untuk melihat Surat Keluar pernah Anda buat sebelumnya</li>
                                <li>Menu Berkas untuk melihat Berkas Unit Kerja (sebagai Administrator Unit) serta Notifikasi Berkas Aktif</li>
                            </ul>
                        </div>
                        <div id="pnlAdmin" style="display:<? echo $pnlAdmin; ?>">
                            <b>Petunjuk Umum: </b>
                            <br />
                            <ul>
                                <li>Klik tab <a id="A6" runat="server" href="?option=Share&task=UKP">Pengaturan Unit Kerja & Pengguna</a>
                                    untuk melihat Unit Kerja dan Pengguna Aplikasi</li>
                                <li>Klik tab <a id="A7" runat="server" href="?option=Share&task=General">Pengaturan Umum</a>
                                    untuk melihat Komponen Pengaturan Umum Aplikasi </li>
                                <li>Klik tab <a id="A8" runat="server" href="?option=Share&task=CLB">Pengaturan Klasifikasi & Berkas</a>
                                    untuk melihat dan mengatur Klasifikasi dan Berkas </li>
                                <li>Klik tab <a id="A9" runat="server" href="?option=AdminReport">Laporan</a>
                                    untuk memilih dan menampilkan Laporan </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>