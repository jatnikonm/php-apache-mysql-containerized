<html> 
<head>
<title></title>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Surat Masuk';
</script>

</head>
<body class="ex_highlight_row">

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">

        <thead>
            <tr>
                <th width="3%">Nomor</th>
                <th width="10%">Status Surat</th>
                <th width="20%">Nomor Surat</th>
                <th width="25%">Asal Surat</th>
                <th width="30%">Hal</th>
                <th>Tanggal Surat</th>
                <th>Tanggal Registrasi</th>
                <th width="1%"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="8" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <th><input type="hidden" name="search_no" value="Search" class="search_init" /></th>
                <th><input type="hidden" name="search_status" value="Search" class="search_init" /></th>
                <th><input type="text" name="search_nomor" value="Search" class="search_init" /></th>
                <th><input type="text" name="search_asal" value="Search" class="search_init" /></th>
                <th><input type="text" name="search_hal" value="Search" class="search_init" /></th>
                <th><input type="text" name="search_tglsurat" value="yyyy-mm-dd" class="search_init" /></th>
                <th><input type="text" name="search_tglregistrasi" value="yyyy-mm-dd" class="search_init" /></th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
   
    </table>
</body>
</html>