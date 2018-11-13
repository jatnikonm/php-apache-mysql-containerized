<script type="text/javascript" language="javascript" src="include/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="include/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/jquery.form.js"></script>
<script type="text/javascript" src="include/jquery.idTabs.min.js"></script>


<script type="text/javascript">
/* -------- JSON --------------------------------------- */
$('#tab6').ready(function() {
    $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting": [[3, "desc"]],
		"sAjaxSource": "Mod/ModMailTL/json.php"
    });
    var table = $('#example').DataTable();

    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

$('#example tbody').on( 'click', 'tr', function () {
        var rowData = table.row( this ).data();
        var Nid = $("#txtNid").val();
  // ... do something with `rowData`
        $msg = confirm("Apakah surat ingin diberkaskan ulang di berkas : "+rowData[1]+" - "+rowData[2]+" ?");
        if($msg)
        {
          $.ajax ({
              url:"Mod/ModMailTL/MailTL_proses.php",
              type: "POST",
              data: "Bid="+rowData[1]+"&task=berkas"+"&Nid="+Nid,
              success: function(msg)
              {
                $("#hal").html(msg);
              }
          })
        }
} );
} );
 /* --------------------------------------------------- */
	function getBack(option, task, page, role){
		location.href = 'index2.php?option=' + option + '&task=' + task + '&page=' + page + '&id=' + role;
	}
	
	function openAgenda(){
		var myArgs;
		window.open('window_lookup.php?option=Agenda', 'myAgenda', 'center=yes,resizable=yes,scroll=no,height=520,width=910,status=no'); 
	}

	//------------------- Berkaskan -------------------------
	function openBerkas(){
		getWindow('search_berkas','');
	}
	
	function resOpenBerkas(){
		TINY.box.hide();
		document.forms.form1.txt1.value = arguments[0];	
	}
	
	function addBerkas(){
		getWindow('add_berkas','&task=newFix');
	}

	function respAddBerkas(){
		TINY.box.hide();
		if (arguments[0] != undefined) {
			//document.forms.form1.txt1.options[(document.forms.form1.txt1.options.length)] = new Option(arguments[0], arguments[1], false, true);
			location.reload();
		}
	}
	
	function addBerkas1(){
		getWindow('add_berkas1','&task=newFix');		
	}
	
	function respAddBerkas1(){
			
	}
	
	function getSelect(from, val){
		document.forms.form1.txt1.value = val;
	}
	
	function setBerkaskan(){
		document.forms.form1.task.value = 'berkaskan';
		document.forms.form1.submit();
	}
	//------------------- ------- -------------------------
	
	
	//------------------------------------------ Reply / Disposisi  ------------------------------------------
	function openRD(str){
		var NId = document.forms.form1.id.value;
		var method = document.forms.form1.hid_RD_method;
		
		document.forms.form1.hid_RD.value = str;
		method.value = 'new';
		getWindow('mailTL_RD', '&task=new' + str + '&modeRD=' + str + '&NId=' + NId);
	}

	function openRD1(str){
		var NId = document.forms.form1.id.value;
		var method = document.forms.form1.hid_RD_method;
		
		document.forms.form1.hid_RD.value = str;
		method.value = 'new';
		
		getWindow('mailTL_RD1', '&task=new' + str + '&modeRD=' + str + '&NId=' + NId);
	}
	
	function openRDEdit(str, id){
		var NId = document.forms.form1.id.value;
		var method = document.forms.form1.hid_RD_method;
		
		document.forms.form1.hid_RD.value = str;
		document.forms.form1.hid_RD_GIRID.value = id;
		method.value = 'edit';
		
		switch(str){
			case "final":
				openFinal('edit');
				break;
			default:
				getWindow('mailTL_RD', '&task=edit' + str + '&modeRD=' + str + '&NId=' + NId + '&GIR_Id=' + id);	
				break;
		}		
		
	}
	
	function openRDPrint(Nid, Gid){
		//var NId = document.forms.form1.id.value;
		openWindow('mailTL_Disp_print', 'NId=' + Nid + '&GIR_Id=' + Gid );
	}
	
	function respOpenRD(){
		switch(arguments[0]){
			case "people":
				getWindow('vw_people', arguments[1]);
				break;
			case "ret_people_RD":
				getSelectRD(arguments[1], arguments[2]);
				break;
		}
	}
	
	function getSelectRD(mode, val){
		var str = document.forms.form1.hid_RD.value;
		var NId = document.forms.form1.id.value;
		var GIR_Id = document.forms.form1.hid_RD_GIRID.value;
		var method = document.forms.form1.hid_RD_method.value;
		
		var peopleIdTo, peopleIdCC;
		peopleIdTo = document.forms.form1.hid_RD_kepada;
		peopleIdCC = document.forms.form1.hid_RD_CC;
		
		if (mode == "kepadaRD"){		
			peopleIdTo.value = (val).replace('-,', '');			
		}else{
			if (peopleIdCC.value != ""){
				peopleIdCC.value += ',' + (val).replace('-,', '');
			}else{
				peopleIdCC.value = (val).replace('-,', '');
			}
		}
		
		getWindow('mailTL_RD', '&task=' + method + str + '&modeRD=' + str + '&NId=' + NId + '&GIR_Id=' + GIR_Id + '&peopleIDKepada=' + peopleIdTo.value + '&peopleIDCC=' + peopleIdCC.value);
		
	}
	
	function doneRD(){
		TINY.box.hide();
		location.reload(true);
	}
	
	//--------------------------------------------------------------------------------------
	
	
	function openFinal(str){
		var NId = document.forms.form1.id.value;
		var GId = document.forms.form1.gid_finale.value;
		getWindow('mailTL_DF', '&task=' + str + 'final&modeRD=' + str + 'final&NId=' + NId + '&GId=' + GId);
	}
	
	function deleteHistory(nid, gid){
		var conf = window.confirm('Apakah Anda Akan Membatalkan Tindaklanjut Surat Ini ?');
		if(conf == true){
			var task = 'deleteTL';
			var option = document.forms.form1.option.value;	
			location.href = 'handle.php?option=' + option + '&task=' + task + '&NId=' + nid + '&GIR_Id=' + gid;
		}
	}
	
	function deleteFile(NId, GIR_Id){
		getWindow('mailTL_delFile', '&NId=' + NId + '&GIR_Id=' + GIR_Id);
	}
	

	//----------------------------------------- Hak Akses -----------------------------------------
	function openHA(){		
		getWindow('vw_people', '&modeTo=tembusan&lookup=upper');
	}
	
	function getSelect(){
		TINY.box.hide();
		var val1 = arguments[1];
		var peopleId = '-';
		if (val1 != ""){
			peopleId += ',' + (val1).replace('-,', '');
			peopleId = (val1).replace('-,', '');
		}
		relocateCC(peopleId);
	}
	
	function relocateCC(peopleId){
		var nid = document.forms.form1.id.value;
		document.getElementById("frmCC").src = 'handle.php?option=MailTL&task=saveHA&id=' + nid + '&count=1&txt1=' + arguments[0];
		//document.getElementById("frmCC").src = 'frame.php?option=MailTL&filetopen=MailTLHA&NId=' + nid;
	}
	
	function saveHA(){
		var nid = document.forms.form1.id;
		var peopleId = document.forms.form1.txtHA;		
		location.href = 'handle.php?option=MailTl&task=saveHA&NId=' + nid.value + '&PeopleId=' + peopleId.value;
	}
	//---------------------------------------------------------------------------------------------
	
	
	function openMetadata(method, id){
		var NId;
		if(id == ''){
			NId = document.forms.form1.id.value;
		}else{
			NId = id;
		}
		getWindow('mailTL_metadata', '&task=' + method + '&NId=' + NId);
	}
	
	function respOpenMetadata(){
		TINY.box.hide();
		location.reload(true);	
	}
	
	function openTutupBerkas(){
		var NId = document.forms.form1.id.value;
		var winH, winW, wUrl;
		winH = 340;
		winW = 650;
		wUrl = 'window.php?option=MailTL&filetopen=MailTLClose&width=650&closeFrom=surat&id=' + NId;
		TINY.box.show({ iframe: wUrl, boxid: window, fixed: false, width: winW, height: winH, opacity: 40 }); 
	}
	
	
	//---------------------------------------- Referensi ---------------------------------------------------
	function changeRef(str){
		var btnRef = document.getElementById("btnRef");
		var form = document.getElementById("div_ref_form");
		var list=document.getElementById("div_ref_list");
		switch(str){
			case "add":
				btnRef.style.display = 'none';
				list.style.display = 'none';
				form.style.display = 'inline';
				break;
			default :
				btnRef.style.display = 'inline';
				form.style.display = 'none';
				list.style.display = 'inline';
				break;
			}
	}
	
	function openRef(id){
		
		var BerkasId = document.forms.form1.txt1.value;
		var myArgs;
		myArgs = window.showModalDialog('window.php?option=MailTL&filetopen=MailTLRef&width=650&task=Ref&NId=' + id + '&BerkasId=' + BerkasId, 'Referensi', 
					'center:yes;resizable:no;scroll=no;dialogHeight:230px;dialogWidth:670px;status=no;');
		if (myArgs != null) {
			location.reload(true);
		}
	}
	
	function delRef(nid, refid){
		location.href = 'handle.php?option=MailTl&task=delRef&NId=' + nid + '&RefId=' + refid;
	}
	
	function openDetail(str){
		window.showModalDialog('frmViewReference.aspx?NId=' + str, 'myRef', 'center:yes;resizable:yes;scroll=yes;dialogHeight:600px;dialogWidth:1024px;status=no;');   
	}
	
	function openInbox(){
		var NId = document.getElementById("Id").value;
		var myArgs;
		myArgs = window.showModalDialog('../../Services/Lookup/frmInbox.aspx?NId=' + NId, 'myBerkas', 'center:yes;resizable:yes;scroll=no;dialogHeight:520px;dialogWidth:1110px;status=no;');   
		if (myArgs != null) {
			if (myArgs.length != 0) {
				document.getElementById("<%= ddlSurat.ClientID %>").value = myArgs.SuratId.toString();
			}
		}
	}
	
	function openRef(id){
		//window.open('window_lookup.php?option=Surat', 'myRef', 'center=yes,resizable=yes,scrollbar=yes,height=530,width=1050,status=no');
		getWindow('vw_surat', '&NId=' + id);
	}
	
	function getSelectSurat(hal, nid, bid, tref){
		document.getElementById('frame_ref').contentWindow.getSelectSurat(hal, nid, bid, tref);
		TINY.box.hide();
	}
	
	function confirmRef(){
		var jenisRef = document.getElementById("<%= ddlJenisRef.ClientID %>").value;
		document.getElementById("<%= JSRefResponse.ClientID %>").value = "false";
		if (jenisRef == 'reply'){
			var confirm = window.confirm("Dengan memasukkan surat ini sebagai Balasan, sistem akan memberkaskan ulang. \nklik 'Ok' untuk melanjutkan 'Cancel' untuk membatalkan.");
			document.getElementById("<%= JSRefResponse.ClientID %>").value = confirm;
		}
	}
	
	function openOthers(jenis, id){
		if(jenis == 'Surat'){
			openMetadata('detail', id);
		}else{
			
		}	
	}
	
</script>