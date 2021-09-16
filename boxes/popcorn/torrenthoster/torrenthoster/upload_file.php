<?php
include("config.php");
include "validator.php";

switch (nvl($_REQUEST["mode"]))

{
	case "upload" :
		upload($_REQUEST["id"]);
		break;
}

function upload($id)
{


  if (($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "image/png")
  && ($_FILES["file"]["size"] < 100000))
    {
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
      // echo "Upload: $id <br />";
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";

	  $ext = substr(strrchr($_FILES["file"]["name"], '.'), 1);

      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";


      if (file_exists("upload/$id.$ext" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
      else
        {
        move_uploaded_file($_FILES["file"]["tmp_name"],
        "upload/$id.$ext");

		$addfilename=db_query("UPDATE namemap SET screenshot='$id.$ext' WHERE info_hash='$id'");

        echo "Upload Completed. <br />Please refresh to see the new screenshot.";

        }

      }
    }
  else
    {
    echo "Invalid file";
    }



}
?>