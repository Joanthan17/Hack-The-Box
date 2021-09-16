<?
include("../config.php");
require_login();
require_priv("admin");

$DOC_TITLE = "WebTorrent Admin Update";
include("templates/header.php");

switch(nvl($_REQUEST["updateSite"])){

	case "datesAndTimes" :
	 printDatesAndTimesForm();
	 break;
	
	case "updateDateandTime" :
	 updateDandT($_POST);
	 echo "<h1>Dates and Times changed sucessfully.</h1>";
	 printDatesAndTimesForm();
	 break; 
	 
	case "registrationTime" :
	printRegistrationTimeForm();
	break;
	
	case "updateRegistrationTime" :
	updateRegTime($_POST);
	echo "<h1>Registration Time changed sucessfully.</h1>";
	printRegistrationTimeForm();
	break;
	
	
	case "questions" :
	printQuestionsForm();
	break;
	
	case "updateQuestions" :
	updateQuestions($_POST);
	echo "<h1>Questions changed sucessfully.</h1>";
	printQuestionsForm();
	break;
	 
} //end switch statement

include("templates/footer.php");

/********************************************************
  Update Functions
  *******************************************************/
  
function printDatesAndTimesForm(){
  
  global $CFG, $ME;
  
  $queryString = "SELECT * FROM datesAndTimes";
  $qid = db_query($queryString);
  $frm = db_fetch_array($qid);
  $frm["newmode"] = "updateDateandTime";
  include "templates/datesAndTimesForm.php";
  
}

function updateDandT($frm){
 
  $queryString = "UPDATE datesAndTimes SET
  			fsDate = '$frm[fsDate]'
			,fsTime1 = '$frm[fsTime1]'
			,fsTime2 = '$frm[fsTime2]'
			,fsTime3 = '$frm[fsTime3]'
			,ssDate = '$frm[ssDate]'
			,ssTime1 = '$frm[ssTime1]'
			,ssTime2 = '$frm[ssTime2]'
			,ssTime3 = '$frm[ssTime3]'
			,tsDate = '$frm[tsDate]'
			,tsTime1 = '$frm[tsTime1]'
			,tsTime2 = '$frm[tsTime2]'
			,tsTime3 = '$frm[tsTime3]'";
  $qid = db_query($queryString);
}
function printRegistrationTimeForm(){
  
  global $CFG, $ME;
  
  $queryString = "SELECT * FROM registrationTime";
  $qid = db_query($queryString);
  $frm = db_fetch_array($qid);
  $frm["newmode"] = "updateRegistrationTime";
  include "templates/registrationTimeForm.php";
  
}
function updateRegTime($frm){
 
  $queryString = "UPDATE registrationTime SET
  			 regDate1= '$frm[regDate1]'
			,regTime1 = '$frm[regTime1]'
			,regDate2 = '$frm[regDate2]'
			,regTime2 = '$frm[regTime2]'
			,regDate3 = '$frm[regDate3]'
			,regTime3 = '$frm[regTime3]'";
			
			
  $qid = db_query($queryString);
}

function printQuestionsForm(){
  
  global $CFG, $ME;
  
	$queryString = "SELECT questionID, question FROM questions";
	$qid = db_query($queryString);
	$frm = db_fetch_array($qid);
	$frm["newmode"] = "updateQuestions";
	$qid = db_query($queryString);
	include "templates/questionsForm.php";
}//end printQuestionsForm function

function updateQuestions($frm){
  $queryString = "SELECT questionID, question FROM questions";
	$qid = db_query($queryString);
	$numberRows = db_num_rows($qid);
	for($i=1; $i <= $numberRows; $i++){
		$passVarToUpdate = "question".$i;
		$queryString = "UPDATE questions SET
	          		question = '$frm[$passVarToUpdate]'
				WHERE questionID = $i
				";		
	$qid = db_query($queryString);
	}//end for loop
}//end updateQuestions function	

?>
