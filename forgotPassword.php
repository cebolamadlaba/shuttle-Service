<?php

     require_once 'inc.php'; 
   /* this is because of angular the if information is in a json format*/
    $data=json_decode(file_get_contents("php://input"));
     
     if (count($data)>0){

            $username = mysqli_real_escape_string($connect, $data->username); 
            $userValue= mysqli_real_escape_string($connect, $data->logValue);     
            $errors = array();
           
                  $user_sel= "select password,email from user where username='$username' and  status= '$userValue' "; 
                  echo $user_sel->password;
           
                     
              $run_query = mysqli_query($connect,$user_sel);
              $check_user = mysqli_num_rows($run_query);

              if($check_user>0)
                {    
                      $select = mysqli_fetch_assoc($run_query);
                     
                     $to =  $select["email"];
                      $subject = "Forgot Password";
                      $message = "Your password is "." ".$select["password"];
                     $headers = "From: Shuttle-Services"; 
                      mail($to,$subject,$message,$headers);

                   $data=1;
                }else{
                  $data=2;
                    
                }    
            } 
            
            print  json_encode($data);
    
?>