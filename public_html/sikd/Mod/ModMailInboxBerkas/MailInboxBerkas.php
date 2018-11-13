<html> 
<head>
<title></title>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Item Surat Dalam Berkas';
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
			"aaSorting": [[5, "desc"]],
			"sAjaxSource": "Mod/ModMailInboxBerkas/bantai1.php?id=<?php echo "$_GET[id]"; ?>"
		});

	} );
</script>


</head>
<body class="ex_highlight_row">

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">

        <thead>
            <tr>
                <th width="3%">Nomor</th>
                <th width="1%"></th>
                <th width="10%">Urgensi Surat</th>
                <th width="25%">Nomor Surat</th>
                <th width="50%">Hal</th>
                <th width="1%">Tanggal Surat</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="7" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
   
    </table>
</body>
</html>