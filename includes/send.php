<?php
// Requiered Headers
header("Access-Control-Allow-Origin");
header("Content-Type: application/json; charset=UTF-8");

if($_POST) {
    $receipent = "siankimsiankim@gmail.com";
    $subject = "Email from my portfolio site";
    $visitor_name = "";
    $visitor_email = "";
    $message = "";
    $fail = array();

    //Cleans and stores first name in the$visitor_name variable
    if(isset($_POST['firstname']) && !empty($_POST['firstname'])) {
        $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "firstname");
    }

    //Cleans and stores last name in the$visitor_name variable
    if(isset($_POST['lastname']) && !empty($_POST['lastname'])) {
        $visitor_name .= " ". filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "lastname");
    }

    //Cleans and stores email in the $visitor_email variable
    if(!empty($_POST['email'])){
        $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    }else{ $error_message.="* Email is required.\n";}

    //Cleans message and stores in $message variable
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $clean = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
        $message = htmlspecialchars($clean);
    }else{
        array_push($fail, "message?");
    }

    $headers = "From: " .$visitor_name. "\r\n" . "Reply-To: " .$visitor_email. "\r\n" ."X-Mailer: PHP/" .phpversion();

    if(count($fail)==0){
        mail($receipent, $subject, $message, $headers);
        $results['message'] = sprintf("Thank you for contact us,%s. We will respond within 24 hours.", $visitor_name);
    }else{
        header("HTTP/1.1 488 You did NOT fill out the form correctly");
        die(json_encode(['message'=> $fail]));
    }

}else{
    $results['message']= "??";
}
echo json_encode($results);
?>