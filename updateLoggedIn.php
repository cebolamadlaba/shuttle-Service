
<?Php      
   //opening connection
     require_once 'inc.php';
                   
    $data=json_decode(file_get_contents("php://input"));
    if (count($data)>0){

               $idnumber=mysqli_real_escape_string($connect, $data->idnumber);
               $logged=mysqli_real_escape_string($connect, $data->logged);
               $currentUser=mysqli_real_escape_string($connect, $data->currentUser);

                
                    $user_sel= "UPDATE user SET logged ='$logged' where idnumber ='$idnumber'";
                
              
                $run_query = mysqli_query($connect,$user_sel); 
             }
          
mysqli_close($connect)
   
?>