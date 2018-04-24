<?Php  
     //opening connection
       require_once 'inc.php';

      //decode json object         
    $patientObj=json_decode(file_get_contents("php://input"));

    if (count($patientObj)>0){
             //assign Variables with json information
              $idNumber=mysqli_real_escape_string($connect, $patientObj->idNo);
              $name=mysqli_real_escape_string($connect, $patientObj->name);
              $Taxis=mysqli_real_escape_string($connect, $patientObj->Taxis);
              $Buses=mysqli_real_escape_string($connect, $patientObj->Buses);
              $Cars=mysqli_real_escape_string($connect, $patientObj->Cars);
              $TaxiTripe=mysqli_real_escape_string($connect, $patientObj->TaxiTripe);        
              $CarTripe=mysqli_real_escape_string($connect, $patientObj->CarTripe); 
              $BusTripe=mysqli_real_escape_string($connect, $patientObj->BusTripe); 
              $email=mysqli_real_escape_string($connect, $patientObj->email);  
              $errors = array();

            
                        //checking if the patient already exist
                        $user_sel= "SELECT * FROM `shuttleservices` where shuttleId ='$idNumber' and '$name'";
                        $run_query = mysqli_query($connect,$user_sel);
                        //ccheck/counting number of rows for the same use if the exist from database
                        $check_user = mysqli_num_rows($run_query);
                      
                        if($check_user>0)
                          { 
                              //use for error msg on controlller
                              $data= 0;
                          }else{
                            //insert to DB

                            $sql = "INSERT INTO shuttleservices(shuttleId,name,contact,taxi,bus,private,taxiprice,privateprice,busprice)
                                  VALUES('$idNumber','$name','$email','$Taxis','$Buses','$Cars','$TaxiTripe','$CarTripe','$BusTripe')";
                      
                          if (!$sql) {
                              die('Invalid query: ' . mysql_error());
                          }
                          if (mysqli_query($connect,$sql)) {
                                 $data= 1;
                            }

                    }
                        
         
                  print  json_encode($data);
    } 
mysqli_close($connect)
    
?>