<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="templates/images/ourphp_login.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../function/plugs/jquery/1.8.3/jquery-1.8.3.min.js"></script>
<script src="../../function/plugs/layer/layer.min.js"></script>
</head>
 
<body>
<?php
// 商品属性调用
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';

if ($_GET['our'] == 'gg'){
echo '<table width="100%" border="0" cellpadding="10">';
echo '	<tr>';
echo '		<td bgcolor="#f4f4f4">';
echo '				 <input type="submit" onclick="isok()" name="Submit" value="确定" style="width:100px; height:25px; line-height:25px; background:#0099CC; color:#FFFFFF; border:0px;" />';
echo '		</td>';
echo '	</tr>';


$sql="select id,OP_Title,OP_Titleto,OP_Value from `ourphp_productspecifications` order by OP_Sorting asc";
$query=mysql_query($sql);

while($ourphp_rs=mysql_fetch_array($query)){
echo '	<tr>';
echo '		<td>';

		echo '			<p><input type="checkbox" name="specifications" value="'.$ourphp_rs[0].'" />&nbsp;&nbsp;'.$ourphp_rs[1].'&nbsp;&nbsp;<span style="font-size:10px; color:#999999;">('.$ourphp_rs[2].')</span></p>';
	
	$arr = explode("|",$ourphp_rs[3]);
 	echo '<p style="margin-top:15px;">';
	foreach($arr as $u){
    echo '<span style="padding:3px; border:1px #CCCCCC solid; text-align:center; margin-right:10px;">'.$u.'</span>';
	}
	echo '</p>';
	
	
echo '		</td>';
echo '	</tr>';
}

mysql_free_result($query);

echo '</table>';
?>
<script>
function isok(){
		var index = parent.layer.getFrameIndex(window.name); 
        var text="";  
        $("input[name=specifications]").each(function() {  
            if ($(this).attr("checked")) {  
                text += ","+$(this).val();  
            }  
        });
		
           $.get(
                   'Specifications.php',
                   {id:text},
                   function(data){
						 parent.$('#ourphp_gg_sj').html(data);
						 parent.layer.tips('看这儿！', '#parentIframe', 5);
						 parent.layer.close(index);
                   }
           );   
};
</script>
<?php
}elseif ($_GET['our'] == 'sx'){


			if ($_GET['id'] == 0){
				echo '';
			}else{

				$sql="select id,OP_Title,OP_Text from `ourphp_productattribute` where `OP_Class` = ".intval($_GET['id'])." order by OP_Sorting asc";
				$query=mysql_query($sql);
				
				echo '<table width="300" border="1" align="left" cellpadding="5" bordercolor="#E3E3E3" style="border-collapse:collapse;">';
				while($ourphp_rs=mysql_fetch_array($query)){
				?>
				
					  <tr>
						<td bgcolor="#F4F0F4"><div align="right"><?php echo $ourphp_rs[1]; ?>：</div></td>
						<td bgcolor="#FFFfff">
						<select name="OP_Pattribute[]">
						<?php
							$arr = explode("|",$ourphp_rs[2]);
							foreach($arr as $u){
								echo '<option value="'.$ourphp_rs[1].':'.$u.'">'.$u.'</option>'; 
							}
						?>
						</select>
						</td>
					  </tr>	
				
				
				<?php
				}
				echo '</table>';
				mysql_free_result($query);
			}
			
			
}
?>
</body>
</html>