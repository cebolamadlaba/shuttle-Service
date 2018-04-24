<?Php  
     //opening connection
       require_once 'inc.php';

      //decode json object         
    $patientObj=json_decode(file_get_contents("php://input"));

    if (count($patientObj)>0){
             //assign Variables with json information
              $idNumber=mysqli_real_escape_string($connect, $patientObj->idNo);
              $FirstName=mysqli_real_escape_string($connect, $patientObj->name);
              $Surname=mysqli_real_escape_string($connect, $patientObj->surname);
              $CellNumber=mysqli_real_escape_string($connect, $patientObj->cellNo);
              $Email=mysqli_real_escape_string($connect, $patientObj->email);
              $Gender=mysqli_real_escape_string($connect, $patientObj->gender);        
              $createDate=mysqli_real_escape_string($connect, $patientObj->createDate); 
              $userState=mysqli_real_escape_string($connect, $patientObj->state);  
              $password=substr($idNumber,9,5); 
              $errors = array();

              if($userState=='Register'){
                        //checking if the patient already exist
                        $user_sel= "SELECT * FROM `user` where idnumber ='$idNumber'";
                        $run_query = mysqli_query($connect,$user_sel);
                        //ccheck/counting number of rows for the same use if the exist from database
                        $check_user = mysqli_num_rows($run_query);
                      
                        if($check_user>0)
                          { 
                              //use for error msg on controlller
                              $data= 0;
                          }else{
                            //insert to DB

                            $sql = "INSERT INTO user(idnumber,name,surname,gender,email,CellNumber,createDate,password,status)
                                  VALUES('$idNumber','$FirstName','$Surname','$Gender','$Email','$CellNumber','$createDate','$password','User')";
                      
                          if (!$sql) {
                              die('Invalid query: ' . mysql_error());
                          }

                    }
                        
                        if (mysqli_query($connect,$sql)) {
                          
                              // $to = $Email;
                               //$subject = "Registration Confirmation";
                               //$message = "Your Username is". " " . $Email . " " ."Passwors is " . $password ;
                              //$headers = "From:Shuttle-Services"; 
                             // mail($to,$subject,$message,$headers);
                               $data= 1;
                          } else {
                            $data= 10;
                          }
                   }else{
                       
                       $update= "UPDATE `user` 
                                 SET `name` = '$FirstName',
                                     `surname` = '$Surname',
                                     `CellNumber`='$CellNumber',
                                     `email` = '$Email',
                                WHERE `idnumber` = '$idNumber'";
                       $run_query =  mysqli_query($connect,$update);
                        $data= 3;
                   }

                  print  json_encode($data);
    } 
mysqli_close($connect)
    
?>