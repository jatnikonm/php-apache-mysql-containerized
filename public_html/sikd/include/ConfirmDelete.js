function changeCheckState(checked){
	var frm  = document.forms[0];
    for (i=0; i<frm.length; i++){
		var obj = frm.elements[i];
        if ((obj.name == 'ids[]') && (obj.type == 'checkbox') && (obj.disabled == false)) {
           	obj.checked = checked;
        }
    }
}
        
function confDelete(){
    //check if there are any selected
    var frm = document.forms[0];
    var a = 0;
    for (i=0; i<frm.length; i++){
		var obj = frm.elements[i];
        if ((obj.name == 'ids[]') && (obj.type == 'checkbox')) {
            if (obj.checked == true){
                a++;      
            }
        }
    }
    if(a == 0){
        alert('Pilih data yang akan dihapus. \n (Gunakan Checkbox pada sisi kiri baris) !');
        return false;
    }else{
        resp = window.confirm ("Apakah anda yakin akan menghapus data ini ? ");
        return resp;
    }
}