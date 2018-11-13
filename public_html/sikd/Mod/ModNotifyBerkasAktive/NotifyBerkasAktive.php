<html> 
<head>
<title></title>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Daftar Berkas Yang Melewati Masa Aktif';
</script>

<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"aaSorting": [[4, "desc"]],
			"sAjaxSource": "Mod/ModNotifyBerkasAktive/bantai1.php"
		});

	} );
</script>


</head>
<body class="ex_highlight_row">

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">

        <thead>
            <tr>
                <th width="3%">Nomor</th>
                <th width="15%">Status Berkas</th>
                <th width="20%">Nomor Berkas</th>
                <th width="50%">Nama Berkas</th>
                <th width="1%">Akhir Retensi Aktif</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="5" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
   
    </table>
</body>
</html>
