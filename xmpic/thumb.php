<?php
$wherelist=array();
$urlist=array();
/*
if(!empty($_GET['id']))
{
$wherelist[]=" id like '%".$_GET['id']."%'";
$urllist[]="id=".$_GET['id'];
}*/
if(!empty($_GET['title']))
{
$wherelist[]=" title like '%".$_GET['title']."%'";
$urllist[]="title=".$_GET['title'];
}
$where="";
if(count($wherelist)>0)
{
$where=" where ".implode(' and ',$wherelist);
$url='&'.implode('&',$urllist);
}
//分页的实现原理
//1.获取数据表中总记录数
$mysql_server_name='localhost'; 
$mysql_username='root'; 
$mysql_password='root'; 
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password);
mysql_query("set names 'utf8'");
mysql_select_db("pyspider");
$sql="select * from xmpic $where "; 
$result=mysql_query($sql);
$totalnum=mysql_num_rows($result);
//每页显示条数
$pagesize=30;
//总共有几页
$maxpage=ceil($totalnum/$pagesize);
$page=isset($_GET['page'])?$_GET['page']:1;
if($page <1)
{
$page=1;
}
if($page>$maxpage)
{
$page=$maxpage;
}
$limit=" limit ".($page-1)*$pagesize.",$pagesize";
//$sql1="select * from xmpic {$where} order by id desc {$limit}"; //此处加了id降序
$sql1="select * from xmpic {$where} order by id {$limit}";
$res=mysql_query($sql1);
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">  
<head runat="server">  
<meta charset="UTF-8">
<title>python爬虫结果显示</title>


<style> 
#login_click{ margin-top:10px; padding-left:12px; height:15px;}  
#login_click a   
{  
    text-decoration:none;
    background:#ffffff;  
    color:#f2f2f2;  
      
    padding: 3px 3px 3px 3px;  
    font-size:12px;
	color:black;	
    font-family: 微软雅黑,宋体,Arial,Helvetica,Verdana,sans-serif;  
    //font-weight:bold;  
    border-radius:3px;  
      
    -webkit-transition:all linear 0.30s;  
    -moz-transition:all linear 0.30s;  
    transition:all linear 0.30s;  
      
    }  
   #login_click a:hover { background:#ff6700; } 

#submitButton
{
	color:#000000;
    padding: 3px 3px 3px 3px;    
    font-size:11px; 
    font-family: 微软雅黑,宋体,Arial,Helvetica,Verdana,sans-serif;  
	border:0.5px solid #ff6700;
	border-radius:5px;  
	background:#ffffff;
	display:block
    
    -webkit-appearance: none;	
	-webkit-border-radius:5px;
	-moz-border-radius:5px; 
 
    filter:chroma(color=#000000);  
    }  
	
a:link {
	color: #000000;/* 未访问的链接 */
	text-decoration: none;/* 去掉链接下划线 */
	} 
a:visited {color: #000000} /* 已访问的链接 */
a:hover {color: #ff6700} /* 鼠标移动到链接上 */
a:active {color: #0000FF} /* 选定的链接 */
</style>
</head>

<body>

<div style="font-size:15px;font-weight:bold;padding-top:5px;padding-left:30px;padding-bottom:3px;color:#ff6700">小米主题商店壁纸列表</div>

<div id=login_click style="font-size:12px;padding-top:0px;padding-left:30px;padding-bottom:25px;">
<form action="thumb.php" method="get">

标题：<input style="background:transparent;border:0.5px solid #ff6700;width:100px;height:15px;font-size:12px" type="text" name="title" value="<?php echo $_GET['title']?>" size="20" style="width: 106; height: 21">
 &nbsp;&nbsp;<input type="submit" id="submitButton" value="搜索">&nbsp;&nbsp;
 <input type="button" id="submitButton" value="显示所有" onclick="window.location='thumb.php'">
</form>
</div>


<div style="padding-left:20px">
<?php while($row= mysql_fetch_assoc($res)){?>
<?php 
echo '<div style="font-size:12px;padding-left:10px;padding-bottom:5px;margin:0 atuo;float:left">';

$thumbnail = str_replace("/w965/","/h160/",$row[wurl]);
//$localurl= preg_replace('/http:\/\/file.market.xiaomi.com\/thumbnail\/jpeg\/w965\/[a-z0-9]{0,3}\/{0,1}/','http://1.2.3.4/pri/html/xmpic/w965/',$row[url]);
//$filename = str_replace('/home/www/web/python/xmpic/image/','',$row[dir]);
//$localimageurl = substr($localurl, 0, 45);
echo '<a href="'.$row[wurl].'" title="标题：'.$row[title].'&#13;大小：'.$row[size].'" target="_blank"><img src="'.$thumbnail.'"></a>';
//echo '<a href="'.$localimageurl.'" title="标题：'.$row[title].'&#13;大小：'.$row[size].'" target="_blank"><img src="'.$thumbnail.'"></a>';
echo '</div>';

?>
<?php }?>
</div>


<div style="clear:both">
<div id=login_click style="font-size:12px;padding-top:10px;padding-left:15px;padding-bottom:5px;text-align:center">
<?php
echo "<a href='thumb.php?page=1{$url}'>首页</a>";
echo "<a href='thumb.php?page=".($page-1)."{$url}'>上一页</a>";
echo "<a href='thumb.php?page=".($page+1)."{$url}'>下一页</a>";
echo "<a href='thumb.php?page={$maxpage}{$url}'>尾页</a>";
echo " 当前{$page}/{$maxpage}页   共{$totalnum}条";
?>
</div>


<div id=login_click style="font-size:12px;padding-top:0px;padding-left:15px;padding-bottom:20px;text-align:center">
<form action="thumb.php" method="get">跳转到第: &nbsp;&nbsp<input style="background:transparent;border:0.5px solid #ff6700;width:40px;height:15px;font-size:12px" type="text" name="page" value="<?php echo $_GET['page']?>" size="3">&nbsp;&nbsp页&nbsp;&nbsp;&nbsp;<input type="submit" id="submitButton" value="确定"></form>
</div>

<div style="font-size:12px;font-weight:bold;text-align:center;padding-top:10px;padding-left:20px;padding-bottom:20px;color:#ffffff;background:#f2f2f2;height:8px">
<a href="http://www.xiaomi.com" target="_blank">探索黑科技，小米为发烧而生！</a>
</div>
</div>

</body>
</html>