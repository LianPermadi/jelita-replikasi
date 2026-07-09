function buatObjectHttp()
{
	var xmlHttp=null;
	try
	{
		xmlHttp=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	if(xmlHttp==null)
	{
		alert("Browser Anda Tidak Mendukung Ajax\nSilahkan Gunakan Browser yang mendukung ajax\nagar Aplikasi dapat berjalan dengan baik");
	}
	return xmlHttp;
}
function kirimPesan(data)
{
	dataxml=buatObjectHttp();
	var isidata=data.toString();
	var urlvar=$('#frmdata').attr('action');
	isidata=isidata+"&sid="+Math.random();
	dataxml.open("POST",urlvar,true);
	dataxml.onreadystatechange=function()
		{
			if (dataxml.readyState==4 || dataxml.readyState=="complete")
			{
				$( "#loading" ).progressbar('destroy');	
                                                                        $( "#dialogloading" ).dialog( "destroy" );
				if(dataxml.responseText=="sukses")
				{
					window.location=ambilUrl()+'generate/step4';	
				}
				else
				{
                                                                                        $( "#loading" ).html(dataxml.responseText);	
                                                                                        
                                                                                        //window.location=ambilUrl()+'generate/error';
				}
			}
			if (dataxml.readyState==1 || dataxml.readyState=="loading")
			{
				$( "#loading" ).progressbar({value: 37}).show();
                                                                        $("#dialogloading").dialog({
                                                                         resizable: false,
                                                                         height:100,width:250,
                                                                         modal: true,title:'Loading data'});
			}
		}
	dataxml.setRequestHeader("content-type","application/x-www-form-urlencoded");
	dataxml.setRequestHeader("content-length",isidata.length);
	dataxml.setRequestHeader("connection","close");
	dataxml.send(isidata);
}


