function getProperty() {
    var wUrl, winW, winH;
    var parr = new Array();
	
	switch (arguments[0]) {
        case "changePass":
            winW = "450";
            winH = "250";
            wUrl = 'window.php?option=ChangePass&filetopen=ChangePass&width=450';
            break;
		case "admin_pengguna":
			winW = "700";
            winH = "730";
			wUrl = 'window.php?option=AdminPengguna&filetopen=AdminPenggunaDetail&width=700';
			break;
		case "admin_uploaddoc":
			winW = "650";
            winH = "220";
			wUrl = 'window.php?option=TemplateDocUp&filetopen=TemplateDocUpDetail&width=700';
			break;
		case "vw_agenda":
			winW = "510";
            winH = "580";
            wUrl = 'window_lookup.php?option=Agenda';
            break;
		case "vw_surat":
			winW = "970";
            winH = "500";
            wUrl = 'window_lookup.php?option=Surat';
            break;
		case "vw_people":
			winW = "970";
            winH = "450";
            wUrl = 'window_lookup.php?option=People';
            break;
		case "vw_berkas_nmr":
			winW = "620";
            winH = "585";
            wUrl = 'window_lookup.php?option=Berkas';
			break;
		case "add_berkas":
			winW = "710";
            winH = "730";
            wUrl = 'window.php?option=AdminBerkas&filetopen=AdminBerkasDetail&width=710';
			break;
		case "add_berkas1":
			winW = "710";
            winH = "730";
            wUrl = 'window.php?option=AdminBerkas&filetopen=AdminBerkasDetail&width=710';
			break;
		case "close_berkas":
			winW = '650';
			winH = '310';
			wUrl = 'window.php?option=AdminBerkas&task=tutupBerkas&filetopen=AdminBerkasClose&width=650';
			break;
		case "open_berkas":
			winW = "450";
            winH = "180";
            wUrl = 'window.php?option=AdminBerkas&task=OpenBerkas&filetopen=AdminBerkasOpen&width=450';
			break;
		case "search_berkas":
			winW = "660";
            winH = "520";
            wUrl = 'window_lookup.php?option=BerkasUK&width=660';
			break;
		case "susut_berkas":
			winW = "660";
            winH = "300";
            wUrl = 'window.php?option=AdminBerkas&task=SusutBerkas&filetopen=AdminBerkasSusut&width=650';
			break;
		case "mailTL_metadata":
			winW = "650";
            winH = "830";
            wUrl = 'window.php?option=Mail&filetopen=Mail&width=650';
			break;
		case "mailTL_RD":
			winW = '615';
			winH = '810';
			wUrl = 'window.php?option=MailTL&filetopen=MailTLRD&width=610';
			break;
		case "mailTL_RD1":
			winW = '615';
			winH = '600';
			wUrl = 'window.php?option=MailTL&filetopen=MailTLRD&width=610';
			break;
		case "mailTL_RD2":
			winW = '615';
			winH = '810';
			wUrl = 'window.php?option=MailTLPimpinan&filetopen=MailTLRD&width=810';
			break;
		case "mailTL_Disp_print":
			winW = '575';
			winH = '500';
			wUrl = 'window_flat.php?option=mailTL&filetopen=MailTLDisposisi&width=575';
			break;
		case "mailTL_Disp_print2":
			winW = '575';
			winH = '500';
			wUrl = 'window_flat.php?option=mailTLPimpinan&filetopen=MailTLDisposisi&width=575';
			break;
		case "mailTL_DF":
			winW = '680';
			winH = '565';
			wUrl = 'window.php?option=MailTL&filetopen=MailTLFinal&width=675';
			break;
		case "mailTL_delFile":
			winW = '630';
			winH = '250';
			wUrl = 'window.php?option=MailTL&filetopen=MailTLDel&width=650&task=delfile';
			break;
		case "MailTLRef":
			winW = '675';
			winH = '275';
			wUrl = 'window.php?option=MailTL&filetopen=MailTLRef&width=675';
			break;
        case "uploadfile":
			winW = '675';
			winH = '475';
			wUrl = 'window.php?option=MailTL&filetopen=add_file&width=675';
			break;			
		}
	
	parr[0] = winW;
    parr[1] = winH;
    parr[2] = wUrl;
    return parr;
}