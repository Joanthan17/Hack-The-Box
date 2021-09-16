<?php
class Validator {

    var $errors; // A variable to store a list of error messages

    function validateGeneral($theinput,$description = ''){
        if (trim($theinput) != "") {
            return true;
        }
	else{
            $this->errors[] = $description;
            return false;
        }
    }
    
    // Validate text only
    function validateTextOnly($theinput,$description = ''){
        $result = ereg ("^[A-Za-z\ ]+$", $theinput );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
    }

    // Validate text only, no spaces allowed
    function validateTextOnlyNoSpaces($theinput,$description = ''){
        $result = ereg ("^[A-Za-z]+$", $theinput );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
    }
        
    // Validate email address
    function validateEmail($themail,$description = ''){
        $result = ereg ("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $themail );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
            
    }
    
    function validatePhone($thePhone,$description = ''){
       $result = ereg("^([0-9]{3})+\-([0-9]{3})+\-([0-9]{4})+$",$thePhone);
       if($result){
          return true;
	}else{
		$this->errors[] = $description;
		return false;
	}
     }//end validate phone function
    
    // Validate numbers only
    function validateNumber($theinput,$description = ''){
        if (is_numeric($theinput)) {
            return true; // The value is numeric, return true
        }else{
            $this->errors[] = $description; // Value not numeric! Add error description to list of errors
            return false; // Return false
        }
    }
    
    function validateAgeLength($theAge, $description = ''){
    	$result = preg_match("/^\-?[0-9]{0,2}$/", $theAge);
	if($result){
		return true;
	}else{
		$this->errors[] = $description;
		return false;
	}
	
    }  	 
    
    function validateZipLength($theZip, $description = ''){
       $result = preg_match("/^\-?[0-9]{5}$/", $theZip);
       if($result){
       		return true;
	}else{
		$this->errors[] = $description;
		return false;
	}
    }//end validate zip length function   
    
    function validateStateLength($theState, $description = ''){
       $result = preg_match("/^\-?[A-Za-z]{2}$/", $theState);
       if($result){
       		return true;
	}else{
		$this->errors[] = $description;
		return false;
	}
    }//end validateStateLength function
    
    // Validate date
    function validateDate($thedate,$description = ''){

        if (strtotime($thedate) === -1 || $thedate == '') {
            $this->errors[] = $description;
            return false;
        }else{
            return true;
        }
    }
    
    // Check whether any errors have been found (i.e. validation has returned false)
    // since the object was created
    function foundErrors() {
        if (count($this->errors) > 0){
            return true;
        }else{
            return false;
        }
    }

    // Return a string containing a list of errors found,
    // Seperated by a given deliminator
    function listErrors($delim = ' '){
        return implode($delim,$this->errors);
    }
    
    // Manually add something to the list of errors
    function addError($description){
        $this->errors[] = $description;
    }    
        
}
?>