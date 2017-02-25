<?php

    $array = array("firstname" => "", "name" => "", "phone" => "", "email" => "", "message" => "", "firstname_error" => "", "name_error" => "", "phone_error" => "", "email_error" => "", "message_error" => "", "isSuccess" => false);

    //email $variable :
    $emailTo = "corentin.terrie@mail.com";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //security check on post $var
        $array["firstname"] = verifyInput($_POST['firstname']);
        $array["name"] = verifyInput($_POST['name']);
        $array["phone"]= verifyInput($_POST['phone']);
        $array["message"] = verifyInput($_POST['message']);
        $array["email"] = verifyInput($_POST['email']);
        $array["isSuccess"] = true;
        
        //email $variable :
        $emailText = "";
        
        
        if(empty($array["firstname"]))
        {
            $array["firstname_error"] = "Le prénom est requis.";
            $array["isSuccess"] = false;
        } 
        else
        {
            $emailText .= "FirstName:" . $array["firstname"] . "\n";    
        }
        
        if(empty($array["name"]))
        {
            $array["name_error"] = "Le nom est requis.";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Name: {$array["name"]} \n";    
        }
        
        if(!isEmail($array["email"]))
        {
            $array["email_error"] = "Ca ressemble bof bof à un email ça!";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Email:" . $array["email"] ."\n";    
        }
        
        if(!isPhone($array["phone"]))
        {
            $array["phone_error"] = "Entrez un numéro avec seulement chiffres et espaces.";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Phone: {$array["phone"]} \n";    
        }
        
        if(empty($array["message"]))
        {
            $array["message_error"] = "Pas de message pas de chocolat!";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Message: {$array["message"]} \n";    
        }
        
        
        /* All the data are successful so we can send the email */
        if($array["isSuccess"])
        {
            $headers = "From : {$array["firstname"]} {$array["name"]} <{$array["email"]}> \r\nReply-To: {$array["email"]}";
            mail($emailTo, "Message from : ", $emailText, $headers);
        }

        echo json_encode($array);
        
    }

    function verifyInput($var)
    {
        $var = trim($var); // remove all supp chars
        $var = stripslashes($var); // remove all /
        $var = htmlspecialchars($var); // create a string of script and join them to html request
        return $var;
    }
    function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
        
    }

    function isPhone($var)
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }
?>
