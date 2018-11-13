<html> 
<head>
<title></title>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Log Registrasi Memo';
</script>

</head>
<body class="ex_highlight_row">

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">

        <thead>
            <tr>
                <th width="3%">Nomor</th>
                <th width="10%">Status Naskah</th>
                <th width="20%">Nomor Naskah</th>
                <th width="25%">Asal Naskah</th>
                <th width="30%">Hal</th>
                <th>Tanggal Naskah</th>
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