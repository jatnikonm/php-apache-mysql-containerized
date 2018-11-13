<script type="text/javascript">
function confDelete(){
	resp = window.confirm ("Apakah anda yakin akan menghapus data ini ? ");
	return resp;
}

function setDelete(id, gid, str){
	if(confDelete() == false){
		return false;
	}else{
		location.href='handle.php?option=Mail&task=delFile&id=' + id + '&GIR_Id=' + gid + '&FName=' + str;
	}	
}
</script>