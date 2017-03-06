<?php
/**
 * Created by PhpStorm.
 * User: elkana
 * Date: 12/12/2016
 * Time: 10:28 PM
 */
$phonenumber=$_GET['MSISDN'];
$sessionId = $_GET['sessionId'];
$servicecode=$_GET['servicecode'];
$ussdString=$_GET['text'];

$regNo= "";
$fName= "";
$lName= "";
$gender="";
$genderV="";
$pass="";
$acceptDeny="";

$username="";
$password="";
$year="";
$semester="";

$level=0;

if ($ussdString !=""){
    $ussdString=str_replace("#","*", $ussdString);
    $ussdString_explode= explode("*",$ussdString);
    $level=count($ussdString_explode);
}

if ($level==0){
    displaymenu();
}

function displaymenu(){
    $ussd_text="welcome to ussd coding. <br> 1.Register <br> 2.login";
    ussd_proceed($ussd_text);
}
function ussd_proceed($ussd_text){
    echo $ussd_text;
}


if ($level>0){
    switch ($ussdString_explode[0]){
        case 1:
            register($ussdString_explode, $phonenumber);
         break;
        case 2:
            login($ussdString_explode, $phonenumber);
            break;
    }
}

function register($details, $phone){
    if (count($details)==1){
        $ussd_text="CON <br> Enter your registration number(username)";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==2){
        $ussd_text="CON <br> Enter your first name";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==3){
        $ussd_text="CON <br> Enter your Last name";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==4){
        $ussd_text="CON <br> select gender <br> 1.Male <br> 2.Female <br>";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==5){
        $ussd_text="CON <br> set your password";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==6){
        $ussd_text="CON <br> Confirm password";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==7){
        $ussd_text="CON <br> 1.Accept terms and Register <br> 2.Cancel";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==8){
        $regNo=$details[1];
        $fName=$details[2];
        $lName=$details[3];
        $genderV=$details[4];
        $pass=$details[5];
        $passConfirm=$details[6];
        $acceptDeny=$details[7];

        if ($genderV=="1"){
            $gender="Male";
        }
        elseif ($genderV=="2"){
            $gender="Female";
        }
        if ($acceptDeny=="1"){
            echo "END <br> details will be put to: <br> Name:$fName  $lName <br>
             Gender:$gender<br> password(encrypted):md5($pass)<br>";
        }
        else {
            $ussd_text="END <br> Session terminated";
            ussd_proceed($ussd_text);
        }
    }
}

function login ($details , $phone){
    if (count($details)==1){
        $ussd_text="CON <br> Enter your username(registration number)";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==2){
        $ussd_text="CON <br> Enter your password";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==3){
        $ussd_text = "CON <br> select your year of study <br> 1. Year ONE <br> 2.Year TWO <br> 3.Year THREE";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==4){
        $ussd_text="CON <br> select semister <br> 1.semister ONE <br> 2.semister TWO";
        ussd_proceed($ussd_text);
    }
    elseif (count($details)==5){
        $username=$details[1];
        $password=$details[2];
        $year=$details[3];
        $semester=$details[4];
        echo "END <br> Fetching your results <br> username:$username<br> 
        password(Encrypted):md5($password)<br> Year:$year<br> Semester:$semester";
    }
}
