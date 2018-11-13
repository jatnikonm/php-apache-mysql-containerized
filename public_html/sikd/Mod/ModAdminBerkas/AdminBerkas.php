<html>
<head>
<title></title>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Daftar Berkas >> ';
</script>

</head>

<body class="ex_highlight_row">
<form id="form1" name="form1" method="post" action="handle.php">
	<input type="hidden" name="roleId" value="<?php echo $_REQUEST["roleId"]; ?>" />
	<input type="hidden" id="option" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="delete" />
	<input type="hidden" name="groupId" value="<?php echo $_SESSION["GroupId"]; ?>" />
	<input type="hidden" name="cond" id="cond" />
	<input type="hidden" name="id" />
    
    <div id="page1" style="display: inline">
    <span class="navIcon">
       <input type="button" id="btnTambah" value="Tambah" onClick="addBerkas('new','')" class="btn_add" />
    </span> <hr/>
    
    <span class="navIcon"><font color="#000000">Berkas Unit Kerja Bawahan :</font>
        <select class="chosen-select form-control" name="uk_bawahan" id="uk_bawahan" onChange="load_uk();" >
			  <?php
                  $sql = "SELECT RoleId, RoleDesc FROM role WHERE RoleId LIKE '".$_SESSION['PrimaryRoleId']."%' and RoleId != 'root'";
                  $role = mysql_query($sql);
                  while($fetch=mysql_fetch_array($role)){
                   echo "<option value='" . $fetch["RoleId"] . "'";
                    if($_REQUEST['roleId'] == $fetch["RoleId"]){
                        echo " selected ";
                    }
                    echo ">" . $fetch["RoleDesc"] . "</option>";
                    //mysql_free_result($role);
                  }
               ?>
        </select>
    </span>
    
    <br /><br />
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th width="3%">No.</th>
                <th width="10%">Status Berkas</th>
                <th width="15%">Nomor Berkas</th>
                <th width="35%">Nama Berkas</th>
                <th>Isi Berkas</th>
                <th>Unit Kerja</th>
                <th>Akhir Retensi Aktif</th>
                <th width="8%">...</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="7" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
    </div>
    
    <div id="page2" style="display: none" >

    <font color="#FF0000" size="3"><label id="lblberkas"></label></font>
    <br><br>
    
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
        <thead>
            <tr>
                <th width="3%">No.</th>
                <th width="10%">Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Asal Surat</th>
                <th width="35%">Hal</th>
                <th>...</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="6" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
    </div>
</form>
</body>
</html>
