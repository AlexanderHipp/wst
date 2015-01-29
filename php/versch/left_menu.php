<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left menu</title>
<script type="text/javascript">
function set(val)
{
     var path=document.getElementById(val).src;
	 var start=path.lastIndexOf("/")+1;
	 var end=path.lastIndexOf(".");
	 var source = path.substring(start,end);
	 //alert(type);
	 if(val==1)
	 {
		 document.getElementById("2").setAttribute("src","../img/meg_401_1.png");
		if(source=="../img/meg_401_0.png")
		  document.getElementById(val).setAttribute("src","news1.jpg");
		else if(source=="news1")
		  document.getElementById(val).setAttribute("src","news.jpg");
	 }
	  
	
}
</script>
</head>

<body>
<table>
<tr>
    <td><img src="../img/meg_401_0.png"id="1"  onclick="set(this.id)" /></td>
    
 </tr>
</table>
</body>
</html>

