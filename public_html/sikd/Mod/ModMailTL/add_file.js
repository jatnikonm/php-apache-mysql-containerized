<script type="text/javascript">
	function setSave(){
		document.forms.form2.submit();
	}

	function close_win(){
		var vReturnValue = new Object();
		vReturnValue.cond = 'ok';
		window.returnValue = vReturnValue;
		window.close();
	}

    function winclose(NId){
      parent.doneWindow();

    }
</script>