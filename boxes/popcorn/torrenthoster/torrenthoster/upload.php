<?
/* check if file is being accessed directly */



//require_once ("lib/functions.php");
require_once ("lib/BDecode.php");
require_once ("lib/BEncode.php");

//dbconn();

function stripslashes_deep($value)
{
   return (is_array($value) ? array_map('stripslashes_deep', $value) :
stripslashes($value));
}

if (get_magic_quotes_gpc())
{
   $_GET    = array_map('stripslashes_deep', $_GET);
   $_POST  = array_map('stripslashes_deep', $_POST);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}



if (isset($_FILES["torrent"]))
   {
   if ($_FILES["torrent"]["error"] != 4)
   {
      $fd = fopen($_FILES["torrent"]["tmp_name"], "rb") or die("File upload error 1\n");
      is_uploaded_file($_FILES["torrent"]["tmp_name"]) or die("File upload error 2\n");
      $alltorrent = fread($fd, filesize($_FILES["torrent"]["tmp_name"]));
      $array = BDecode($alltorrent);
      if (!isset($array))
         {
         echo "This is not a valid torrent file";
         exit;
         }
      if (!$array)
         {
         echo "This is not a valid torrent file";
         exit;
         }
      $hash = sha1(BEncode($array["info"]));
      fclose($fd);
      }

if (isset($_POST["filename"]))
   $filename=StripSlashes(strip_tags($_POST["filename"]));
else
    $filename = StripSlashes($_FILES["torrent"]["name"]);

$url = "torrents/" . $hash . ".btf";

if (isset($_POST["info"]))
   $comment =strip_tags( $_POST["info"]);
else
    $comment = "";
if (isset($_POST["autoset"]))
   {
   if (strcmp($_POST["autoset"], "enabled") == 0)
      {
      if (strlen($filename) == 0 && isset($array["info"]["name"]))
         $filename = $array["info"]["name"];
      if (isset($array["comment"]))
         $info = $array["comment"];
      else
          $info = "";
      }
   }

$upfile=$array["info"];

if (isset($upfile["length"]))
{

  $size = $upfile["length"];

}
else if (isset($upfile["files"]))
     {
// multifiles torrent
         $size=0;
         foreach ($upfile["files"] as $file)
                 {
                 $size+=intval($file["length"]);
                 }
     }
else
    $size = "0";

      $filename = strip_tags($filename);
      $url = strip_tags($url);
      $info = preg_quote(strip_tags($info),'"');
      $categoria = 0+$_POST["type"];
      $categoria = strip_tags($categoria);
	  $scategoria = 0+$_POST["subtype"];
	  $scategoria = strip_tags($scategoria);
      $comment = strip_tags($comment);
      $announce=$array["announce"];
      $anonyme=$_POST["hideuser"];

	  $hash = strip_tags ($hash);
      if ($categoria==0)
         {
echo "you did not fill in the category";
             exit();
         }


      if ((strlen($hash) != 40) || !verifyHash($hash))
      {
         echo("<center><FONT COLOR=\"red\">Hash error</FONT></center>");
         exit ();
      }
if ($userUpload == "") $userUpload = "Guest";
         $query = "INSERT INTO namemap (info_hash, filename, filename2, url, info, category, subcategory, data, size, comment,announce_url, uploader,anonymous,registration)
VALUES
(\"$hash\", \"$filename\", \"$filename\", \"$url\", \"$info\",0 + $categoria, $scategoria, NOW(), \"$size\", \"$comment\",\"$announce\",\"$userUpload\",'$anonyme',\"$registration\")";


	$result=db_query("SELECT * FROM namemap where info_hash=\"$hash\"");
	if (mysql_num_rows($result) == 0)
	{

      db_query($query);
         move_uploaded_file($_FILES["torrent"]["tmp_name"] , $CFG->torrents ."/" . $hash . ".btf") or die("Error moving torrent...");
                //print("<center>Please wait one moment...<br /></center>");
                require_once("lib/getscrape.php");
                scrape($announce,$hash);
		echo "<div>file upload succes...thank you!</div>";
		include("$CFG->templatedir/footer.php");
		redirect("$CFG->wwwroot/torrents.php?mode=details&id=$hash","file upload succes",0);
		exit();

	}
      else
          {
              echo "this torrent allready exists in our database";
              unlink($_FILES["torrent"]["tmp_name"]);
			include("$CFG->templatedir/footer.php");

				  exit();

          }
}
else
{
?>
<script language="javascript">
// Chained Menu

// Copyright Xin Yang 2004
// Web Site: www.yxScripts.com
// EMail: m_yangxin@hotmail.com
// Last Updated: 2004-08-23

// This script is free as long as the copyright notice remains intact.

var _disable_empty_list=false;
var _hide_empty_list=false;

// ------

///// DynamicDrive.com added function/////////////

var onclickaction="alert"

function goListGroup(){
for (i=arguments.length-1;i>=0; i--){
if (arguments[i].selectedIndex!=-1){
var selectedOptionvalue=arguments[i].options[arguments[i].selectedIndex].value
if (selectedOptionvalue!=""){
if (onclickaction=="alert")
alert(selectedOptionvalue)
else if (newwindow==1)
window.open(selectedOptionvalue)
else
window.location=selectedOptionvalue
break
}
}
}
}

///// END DynamicDrive.com added function//////


if (typeof(disable_empty_list)=="undefined") { disable_empty_list=_disable_empty_list; }
if (typeof(hide_empty_list)=="undefined") { hide_empty_list=_hide_empty_list; }

var cs_goodContent=true, cs_M="M", cs_L="L", cs_curTop=null, cs_curSub=null;

function cs_findOBJ(obj,n) {
  for (var i=0; i<obj.length; i++) {
    if (obj[i].name==n) { return obj[i]; }
  }
  return null;
}
function cs_findContent(n) { return cs_findOBJ(cs_content,n); }

function cs_findM(m,n) {
  if (m.name==n) { return m; }

  var sm=null;
  for (var i=0; i<m.items.length; i++) {
    if (m.items[i].type==cs_M) {
      sm=cs_findM(m.items[i],n);
      if (sm!=null) { break; }
    }
  }
  return sm;
}
function cs_findMenu(n) { return (cs_curSub!=null && cs_curSub.name==n)?cs_curSub:cs_findM(cs_curTop,n); }

function cs_contentOBJ(n,obj){ this.name=n; this.menu=obj; this.lists=new Array(); this.cookie=""; }; cs_content=new Array();
function cs_topmenuOBJ(tm) { this.name=tm; this.items=new Array(); this.df=0; this.addM=cs_addM; this.addL=cs_addL; }
function cs_submenuOBJ(dis,link,sub) {
  this.name=sub;
  this.type=cs_M; this.dis=dis; this.link=link; this.df=0;

  var x=cs_findMenu(sub);
  this.items=x==null?new Array():x.items;

  this.addM=cs_addM; this.addL=cs_addL;
}
function cs_linkOBJ(dis,link) { this.type=cs_L; this.dis=dis; this.link=link; }

function cs_addM(dis,link,sub) { this.items[this.items.length]=new cs_submenuOBJ(dis,link,sub); }
function cs_addL(dis,link) { this.items[this.items.length]=new cs_linkOBJ(dis,link); }

function cs_showMsg(msg) { window.status=msg; }
function cs_badContent(n) { cs_goodContent=false; cs_showMsg("["+n+"] Not Found."); }

function cs_optionOBJ(text,value) { this.text=text; this.value=value; }
function cs_emptyList(list) { for (var i=list.options.length-1; i>=0; i--) { list.options[i]=null; } }
function cs_refreshList(list,opt,df) {
  cs_emptyList(list);

  for (var i=0; i<opt.length; i++) {
    list.options[i]=new Option(opt[i].text, opt[i].value);
  }

  if (opt.length>0) {
    list.selectedIndex=df;
  }
}
function cs_getOptions(menu) {
  var opt=new Array();
  for (var i=0; i<menu.items.length; i++) {
    opt[i]=new cs_optionOBJ(menu.items[i].dis, menu.items[i].link);
  }
  return opt;
}
function cs_updateListGroup(content,idx,sidx,mode) {
  var i=0, curItem=null, menu=content.menu;

  while (i<idx) {
    menu=menu.items[content.lists[i++].selectedIndex];
  }

  if (menu.items[sidx].type==cs_M && idx<content.lists.length-1) {
    var df=cs_getIdx(mode,content.cookie,idx+1,menu.items[sidx].df);

    cs_refreshList(content.lists[idx+1], cs_getOptions(menu.items[sidx]), df);
    if (content.cookie) {
      cs_setCookie(content.cookie+"_"+(idx+1),df);
    }

    if (idx+1<content.lists.length) {
      if (disable_empty_list) {
        content.lists[idx+1].disabled=false;
      }
      if (hide_empty_list) {
        content.lists[idx+1].style.display="";
      }

      cs_updateListGroup(content,idx+1,df,mode);
    }
  }
  else {
    for (var s=idx+1; s<content.lists.length; s++) {
      cs_emptyList(content.lists[s]);

      if (disable_empty_list) {
        content.lists[s].disabled=true;
      }
      if (hide_empty_list) {
        content.lists[s].style.display="none";
      }

      if (content.cookie) {
        cs_setCookie(content.cookie+"_"+s,"");
      }
    }
  }
}
function cs_initListGroup(content,mode) {
  var df=cs_getIdx(mode,content.cookie,0,content.menu.df);

  cs_refreshList(content.lists[0], cs_getOptions(content.menu), df);
  if (content.cookie) {
    cs_setCookie(content.cookie+"_"+0,df);
  }

  cs_updateListGroup(content,0,df,mode);
}

function cs_updateList() {
  var content=this.content;
  for (var i=0; i<content.lists.length; i++) {
    if (content.lists[i]==this) {
      if (content.cookie) {
        cs_setCookie(content.cookie+"_"+i,this.selectedIndex);
      }

      if (i<content.lists.length-1) {
        cs_updateListGroup(content,i,this.selectedIndex,"");
      }
    }
  }
}

function cs_getIdx(mode,name,idx,df) {
  if (mode) {
    var cs_idx=cs_getCookie(name+"_"+idx);
    if (cs_idx!="") {
      df=parseInt(cs_idx);
    }
  }
  return df;
}

function _setCookie(name, value) {
  document.cookie=name+"="+value;
}
function cs_setCookie(name, value) {
  setTimeout("_setCookie('"+name+"','"+value+"')",0);
}

function cs_getCookie(name) {
  var cookieRE=new RegExp(name+"=([^;]+)");
  if (document.cookie.search(cookieRE)!=-1) {
    return RegExp.$1;
  }
  else {
    return "";
  }
}

// ----
function addListGroup(n,tm) {
  if (cs_goodContent) {
    cs_curTop=new cs_topmenuOBJ(tm); cs_curSub=null;

    var c=cs_findContent(n);
    if (c==null) {
      cs_content[cs_content.length]=new cs_contentOBJ(n,cs_curTop);
    }
    else {
      delete(c.menu); c.menu=cs_curTop;
    }
  }
}

function addList(n,dis,link,sub,df) {
  if (cs_goodContent) {
    cs_curSub=cs_findMenu(n);

    if (cs_curSub!=null) {
      cs_curSub.addM(dis,link||"",sub);
      if (typeof(df)!="undefined") { cs_curSub.df=cs_curSub.items.length-1; }
    }
    else {
      cs_badContent(n);
    }
  }
}

function addOption(n,dis,link,df) {
  if (cs_goodContent) {
    cs_curSub=cs_findMenu(n);

    if (cs_curSub!=null) {
      cs_curSub.addL(dis,link||"");
      if (typeof(df)!="undefined") { cs_curSub.df=cs_curSub.items.length-1; }
    }
    else {
      cs_badContent(n);
    }
  }
}

function initListGroup(n) {
  var _content=cs_findContent(n), count=0;
  if (_content!=null) {
    content=new cs_contentOBJ("cs_"+n,_content.menu);
    cs_content[cs_content.length]=content;

    for (var i=1; i<initListGroup.arguments.length; i++) {
      if (typeof(arguments[i])=="object" && arguments[i].tagName && arguments[i].tagName=="SELECT") {
        content.lists[count]=arguments[i];

        arguments[i].onchange=cs_updateList;
        arguments[i].content=content; arguments[i].idx=count++;
      }
      else if (typeof(arguments[i])=="string" && /^[a-zA-Z_]\w*$/.test(arguments[i])) {
        content.cookie=arguments[i];
      }
    }

    if (content.lists.length>0) {
      cs_initListGroup(content,content.cookie);
    }
  }
}

function resetListGroup(n) {
  var content=cs_findContent("cs_"+n);
  if (content!=null && content.lists.length>0) {
    cs_initListGroup(content,"");
  }
}
// ------

</script>
<script language="javascript">
//var hide_empty_list=true; //uncomment this line to hide empty selection lists
var disable_empty_list=true; //uncomment this line to disable empty selection lists

var onclickaction="alert" //set to "alert" or "goto". Former is for debugging purposes, to tell you the value of the final selected list that will be used as the destination URL. Set to "goto" when below configuration is all set up as desired.

var newwindow=0 //Open links in new window or not? 1=yes, 0=no.

/////DEFINE YOUR MENU LISTS and ITEMS below/////////////////

addListGroup("chainedmenu", "First-Select");

addOption("First-Select", "(Choose)", "", 1); //HEADER OPTION

<?php
$result = mysql_query("SELECT id, name FROM categories ORDER BY name ASC ") or sqlerr();
while ($row = mysql_fetch_assoc($result))
{

echo "addList(\"First-Select\", \"";
echo $row['name'];
echo "\", \"";
echo $row['id'];
echo "\", \"";
echo $row['id'];
echo "\");\n";
}
?>

<?php
$result2 = mysql_query("SELECT id, catid, name FROM subcategories ORDER BY name ASC ") or sqlerr();
while ($row2 = mysql_fetch_assoc($result2))
{

echo "addOption(\"";
echo $row2['catid'];
echo "\", \"";
echo $row2['name'];
echo "\", \"";
echo $row2['id'];
echo "\");\n";
}
?>
</script>
<body onload="initListGroup('chainedmenu', document.upload.type, document.upload.subtype, 'saveit')">


<div class="navbar"><ul>
  <li>You can upload torrents that are tracked by any tracker.</li>
  <li>Your torrent <b>MUST NOT CONTAIN Adult Materials, Politics, Illegal Software, or any other.</b>.</li>
  <li>Be patient while the script retrieves the data from the tracker. This may take a while.</li>
  <li><?=$CFG->webname?> reserve the rights to delete any torrent at anytime.</li>
</ul>
</div>
<FORM name="upload" METHOD="POST" ENCTYPE="multipart/form-data">

<table width="100%" border="0" class="infotable">
  <tr>
      <td>Torrent</td>
    <td><input type="file" name="torrent"></td>
  </tr>
    <tr>
      <td>Optional name</td>
    <td><input type=text name="filename" size=50 maxlength=200></td>
  </tr>
  <tr>
      <td>Category</td>
    <td><select name="type">
	<option value="0">(Choose)</option>
<?php
$result = mysql_query("SELECT id, name FROM categories ORDER BY name ASC ") or sqlerr();
while ($row = mysql_fetch_assoc($result))
{

echo "<option value=\"";
echo $row['id'];
echo "\">";
echo $row['name'];
echo "</option>";
}
?>
      </select>

 <tr>
      <td>Subcategory</td>
    <td><select name="subtype">
	<option value="0">(Choose)</option>
 <?php
$result2 = mysql_query("SELECT id, name FROM subcategories ORDER BY name ASC ") or sqlerr();
while ($row2 = mysql_fetch_assoc($result2))
{

echo "<option value=\"";
echo $row2['id'];
echo "\">";
echo $row2['name'];
echo "</option>";
}
?>

      </select>
      <input type=hidden name=user_id size=50 value= >
      <input type= hidden "radio" name="anonymous2" value="false" checked />
      <input type= hidden "radio" name="anonymous" value="true" />
      <input type= hidden checkbox name="autoset" value="enabled" checked></td>
  </tr>
	<tr>
        <td>
                Description
        </td>
        <td>
                <textarea cols="50" rows="7" name="info"></textarea>
        </td>
</tr>

<tr>
	<td>Tracker requires registration</td>
	<td><input type="radio" name="registration" value="true"/>Yes
    <input type="radio" name="registration" value="false" checked="checked"/>No
 </tr>
 <?php

    if ($userUpload != "")
    {?>
<tr>
	<td>Post Annoymous</td>
	<td><input type="radio" name="hideuser" value="true"/>Yes
	   <input type="radio" name="hideuser" value="false" checked="checked"/>No
</tr>
<?}else { ?>

<input type= hidden "radio" name="hideuser" value="false" />

<?}
?>

    <tr>
    <td>&nbsp;</td>
      <td><br /><input class="button" name="submit" type="submit" value="Upload Torrent">



</td>
  </tr>
</table>
  </FORM>

<?
}
?>