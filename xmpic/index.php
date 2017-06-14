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
$pagesize=25;
//$pagesize=$_GET['pagesize'];
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

#parent {
    background: url('yourimage') no-repeat;
	font-size: 12px
    width: 30px;
    height: 10px;
    overflow: hidden;
}

#parent select {
    background: transparent;
    border: none;
    padding-left: 10px;
    width: 30px;
    height: 10px;
} 
  
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
	
.tb 
     {
        width:90%;
        height:8px; 
		border:solid #ff6700;
		border-width:0.5px 0.5px 0.5px 0.5px;
		//padding:10px 0px;
        border-collapse:collapse;
		padding:2px 2px 2px 2px;
		vertical-align:middle;
		text-align:left;
		//font-weight:bold;
     }
.tb td
     {
         border:0.5px solid #ff6700;
		 padding:2px 2px 2px 2px;
    }

.tds{border:solid #add9c0; border-width:0px 1px 1px 0px; padding:10px 0px;}
.table{border:solid #add9c0; border-width:1px 0px 0px 1px;}
	
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


<div style="font-size:15px;font-weight:bold;padding-top:5px;padding-left:10px;padding-bottom:3px;color:#ff6700">小米主题商店壁纸列表</div>


<!--
<div style="display:inline-block"> 
-->

<div id=login_click style="float:left;font-size:12px;padding-top:0px;padding-left:10px;padding-bottom:25px;">
<form action="index.php" method="get">

标题：<input style="background:transparent;border:0.5px solid #ff6700;width:100px;height:15px;font-size:12px" type="text" name="title" value="<?php echo $_GET['title']?>" size="20" style="width: 106; height: 21">
 &nbsp;&nbsp;<input type="submit" id="submitButton" value="搜索">&nbsp;&nbsp;
 <input type="button" id="submitButton" value="显示所有" onclick="window.location='index.php'">
</form>
</div>

<!--

<div id=login_click style="float:left;font-size:12px;padding-top:0px;padding-left:15px;padding-bottom:15px;">


    <form action="index.php" method="GET"> 
    <label>每页显示条数</label> 
    <select name="pagesize">
	<option value='' selected>-请选择-</option>
    <option value="20">20</option> 
    <option value="30">30</option> 
	<option value="50">50</option> 
	<option value="100">100</option> 
	<option value="200">200</option> 
    </select> 
	<input type="submit" id="submitButton" value="确定">
    </form> 

</div>

-->

<!--
</div>
-->

<br/>


<div style="font-size:12px;padding-left:10px">
<table class="tb">


 <tr>
 <td class="tds" style="font-weight:bold">序号</td>
 <td style="font-weight:bold">标题</td>
 <td style="font-weight:bold">链接</td>
 <td style="font-weight:bold">大小</td>
 </tr>
<?php while($row= mysql_fetch_assoc($res)){?>
<tr>
 <td style="bgcolor:#ff6700"><?php echo $row['id'] ?></td>
 <td style="bgcolor:#ff6700"><?php echo $row['title'] ?></td>
 <!--
 <td><?php echo $row['url'] ?></td>
 -->
<?php 
echo '<td style="bgcolor:#ff6700"><a href="'.$row[url].'" target="_blank">'.$row[url].'</a></td>';
?>
 <td style="bgcolor:#ff6700"><?php echo $row['size'] ?></td>
</tr>
<?php }?>
</table>
</div>



<div id=login_click style="float:center;font-size:12px;padding-top:10px;padding-left:15px;padding-bottom:5px;text-align:center">

<?php


echo "<a href='index.php?page=1{$url}'><span>首页</span></a>";

echo "<a href='index.php?page=".($page-1)."{$url}'><span>上一页</span></a>";

echo "<a href='index.php?page=".($page+1)."{$url}'><span>下一页</span></a>";

echo "<a href='index.php?page={$maxpage}{$url}'><span>尾页</span></a>";

echo " <span>当前{$page}/{$maxpage}页   共{$totalnum}条</span>";
?>
</div>


<div id=login_click style="float:center;font-size:12px;padding-top:0px;padding-left:15px;padding-bottom:20px;text-align:center">
<form action="index.php" method="get"><span>跳转到第: &nbsp;&nbsp<input style="background:transparent;border:0.5px solid #ff6700;width:40px;height:15px;font-size:12px" type="text" name="page" value="<?php echo $_GET['page']?>" size="3">&nbsp;&nbsp页&nbsp;&nbsp;&nbsp;</span><input type="submit" id="submitButton" value="确定"></form>
</div>

<div style="font-size:12px;font-weight:bold;text-align:center;padding-top:10px;padding-left:20px;padding-bottom:20px;color:#ffffff;background:#f2f2f2;height:8px">
<a href="http://www.xiaomi.com" target="_blank">探索黑科技，小米为发烧而生！</a>
</div>

</body>
</html>