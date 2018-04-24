<!DOCTYPE html>
<html lang="en" data-ng-app="shuttle">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/angular-toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style3.css">
</head>
<body ng-controller="adminController">
    <div class="col-md-12 header">
       <div class="logo"><h3 style="color:white;font-size:1.8em;text-align:right;">Admin Section</h3></div> 
    </div>
    <div class="col-md-12 nav-pills-container">
        <ul class="nav nav-pills">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span> </a></li>  
            <li class="selected-nav-item"><a href="">View Shuttles Activities</a></li>
            <li class="selected-nav-item"><a href="admin-report.php">Reports</a></li>
            <li class="logout-li"><a ng-click="logout()"><div class="glyphicon glyphicon-log-out"></div> Logout</a></li>
        </ul>
    </div>
    <div class="col-md-12 search-and-results-container"> 
      <button class="btn btn-primary" ng-click="openUpdateModal(details)"> Edit Profile </button>
      <button class="btn btn-primary" ng-click="openRegModal()"> Add User </button>
     
    </div>
    <div class="col-md-12 search-and-results-container">
          <!-- Search bar -->
         <div class="input-group add-on">
             <input class="form-control" placeholder="Search User" name="srch-term" id="srch-term" type="text"  ng-model="filterUsers">
               <div class="input-group-btn">
                    <button class="btn btn-default-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
             </div>
          </div>
      <!-- Results table -->
     <div class="table-container">             
            <table class="table table-bordered table-hover header-fixed table-striped">
                <thead>
                <tr>
                     <th>User ID</th>
                     <th>Name</th>
                     <th>Surname</th>
                     <th>Gender</th>
                     <th>Registered date</th>
                     <th>User type</th>
                     <th>Contact</th>                    
                     <th>Active</th>
                     <th></th>                      
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="patient in patients | filter:filterUsers">
                    <td>
                       {{patient.idnumber}}
                    </td>
                    <td>{{patient.name}}</td>
                    <td>{{patient.surname}}</td>
                    <td>
                        {{patient.gender}}
                    </td>
                    <td>
                      {{patient.createDate}}  
                    </td>
                    <td>
                      {{patient.status}}  
                    </td>
                    <td>{{patient.cellnumber}}  {{patient.email}}</td>
                    <td> 
                        <button class="btn btn-primary" ng-click="openUpdateModal(patient)">Edit</button>
                        <button  ng-if="patient.active=='1'" ng-model="patient.state=0"  class="btn btn-info" ng-click="delete(patient)"><span class="glyphicon glyphicon-thumbs-up"> </span> Active</button>
                        <button ng-if="patient.active=='0'" ng-model="patient.state=1"  class="btn btn-warning"  ng-click="delete(patient)"><span class="glyphicon glyphicon-thumbs-down"></span> In-Active</button>   
                        <button ng-if="patient.status=='Shuttle'" class="btn btn-primary" ng-click="openShuttleModal(patient)"> Add Shuttle Service </button>          
                   </td>
                   <td>
                   </td>
                </tr>               
              </tbody>
        </table>
     </div>
	<!-- //banner -->
	<script type="text/ng-template" id="RegModalContent.html">
    <!-- Patient Registration Modal -->
        <form class="form-horizontal" name="registerForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="close()">&times;</button>
                <h4 class="modal-title">{{updateStatus}} {{patientData.logValue}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-6">                      
                            <div class="form-group" >
                                <label class="control-label col-sm-3">ID No:</label>
                                <div class="col-sm-9" ng-keyup="ValidateIdnumber()" ng-class="{'has-error' : registerForm.IDNo.$invalid && !registerForm.IDNo.$pristine }" >
                                    <input type="text" class="form-control" id="id_number" name="id_number"  ng-model="patientData.idNumber" ng-pattern="/^[0-9]{13}$/" ng-readonly="{{truefalse}}" required>                  
                                      <span style="color:red" ng-show="registerForm.id_number.$pristine && registerForm.id_number.$invalid "> ID number is required.</span>
                                     <br /> <span id="errors" style="color:red" ></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="name">Name:</label>
                                <div class="col-sm-9" ng-class="{'has-error' : registerForm.FirstName.$invalid && !registerForm.FirstName.$pristine }" >
                                    <input type="text" class="form-control" id="FirstName" name="FirstName"  ng-model="patientData.FirstName" maxLength='25' ng-pattern="/^[a-zA-Z_-]*$/"  ng-readonly="{{truefalse}}" required>
                                     <span style="color:red" ng-show="registerForm.FirstName.$pristine && registerForm.FirstName.$invalid"> name is required.</span>
                                     <span style="color:red" ng-show="registerForm.FirstName.$error.pattern">incorrect name format</span> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Surname:</label>
                                <div class="col-sm-9" ng-class="{'has-error' : registerForm.Surname.$invalid && !registerForm.Surname.$pristine }">
                                    <input type="text" class="form-control" name="Surname"  data-ng-model="patientData.Surname" ng-pattern="/^[a-zA-Z_-]*$/" maxLength='25'  ng-readonly="{{truefalse}}" required >
                                     <span style="color:red" ng-show="registerForm.Surname.$pristine && registerForm.Surname.$invalid"> surname is required.</span>
                                    <span style="color:red" ng-show="registerForm.Surname.$error.pattern">incorrect surname format</span>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-sm-6" > 
                            <div class="form-group">
                                <label class="control-label col-sm-3">Email:</label>
                                <div class="col-sm-9" ng-class="{'has-error' : registerForm.Email.$invalid && !registerForm.Email.$pristine }">
                                    <input type="email" class="form-control" name="email"  ng-model="patientData.Email" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{1,3})$/" required>
                                    <span style="color:red" ng-show="registerForm.email.$pristine && registerForm.email.$invalid"> email required.</span>
                                    <span style="color:red" ng-show="registerForm.email.$error.pattern"></span>
                                </div>
                            </div>                           
                            <div class="form-group">
                                <label class="control-label col-sm-3">Cell no:</label>
                                <div class="col-sm-9" ng-class="{'has-error' : registerForm.CellNumber.$invalid && !registerForm.CellNumber.$pristine }">
                                    <input type="text" class="form-control" name="CellNumber"  ng-model="patientData.CellNumber" ng-pattern="/^[0-0][6-8][0-9]{8}$/" maxLength='10' required>                     
                                      <span style="color:red" ng-show="registerForm.CellNumber.$pristine && registerForm.CellNumber.$invalid"> cell number is required.</span>
                                    <span style="color:red" ng-show="registerForm.CellNumber.$error.pattern">cell number is incorrect</span> 
                                </div>
                            </div>
                             <div class="form-group" >
                            <div class"col-md-12">
                                 <div class="col-md-3">
                                        <label class="radioBtnLabel" style="padding:3px" >User</label><input  type="radio" data-ng-model="patientData.logValue" value="User">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="radioBtnLabel" style="padding:3px">Admin</label><input  type="radio" data-ng-model="patientData.logValue" value="Admin">
                                    </div>
                                 <div class="col-md-3">
                                     <label class="radioBtnLabel" style="padding:3px" >Shuttle</label><input type="radio"  data-ng-model="patientData.logValue" value="Shuttle"> 
                                 </div>
                                 
                             </div>    
                             <br>
                             </div>                                                   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" value="submit"  data-ng-click="save()">{{updateStatus}}</button>
                <button type="button" class="btn btn-default" ng-click="close()">Close</button>
            </div>
        </form>
   </script>

   <script type="text/ng-template" id="openShuttleModal.html">
    <!-- Patient Registration Modal -->
        <form class="form-horizontal" name="registerForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="close()">&times;</button>
                <h4 class="modal-title">Add Shuttle Service</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                                <label class="control-label col-sm-4" for="name">Shuttle Name:</label>
                                <div class="col-sm-5" ng-class="{'has-error' : registerForm.FirstName.$invalid && !registerForm.FirstName.$pristine }" >
                                    <input type="text" class="form-control" id="FirstName" name="FirstName"  ng-model="pat.FirstName"  ng-pattern="/^[a-zA-Z_-]*$/"  required>
                                     <span style="color:red" ng-show="registerForm.FirstName.$pristine && registerForm.FirstName.$invalid"> Name is required.</span>
                                     <span style="color:red" ng-show="registerForm.FirstName.$error.pattern">Incorrect Name format</span> 
                                </div>
                            </div>
                    <div class="col-sm-6">                      
                        <div class="form-group" >
                            <label class="control-label col-sm-5">Number of Buses</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.Buses.$invalid && !registerForm.Buses.$pristine }" >
                                <input type="text" class="form-control"  name="Buses"  ng-model="pat.Buses" ng-pattern="/^[0-9]*$/"  required>                  
                                <span style="color:red" ng-show="registerForm.Buses.$pristine && registerForm.Buses.$invalid"> Taxis is required.</span>
                                <span style="color:red" ng-show="registerForm.Buses.$error.pattern">Invalid Format</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5" >Number of Taxis</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.Taxis.$invalid && !registerForm.Taxis.$pristine }" >
                                <input type="text" class="form-control" id="Taxis" name="Taxis"  ng-model="pat.Taxis"  ng-pattern="/^[0-9]*$/"   required>
                                 <span style="color:red" ng-show="registerForm.Taxis.$pristine && registerForm.Taxis.$invalid"> Taxis is required.</span>
                                 <span style="color:red" ng-show="registerForm.Taxis.$error.pattern">Invalid Format</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">Number of Cars:</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.Cars.$invalid && !registerForm.Cars.$pristine }">
                                <input type="text" class="form-control" name="Cars"  data-ng-model="pat.Cars"  ng-pattern="/^[0-9]*$/" required >
                                 <span style="color:red" ng-show="registerForm.Cars.$pristine && registerForm.Cars.$invalid"> Cars  required.</span>
                                <span style="color:red" ng-show="registerForm.Cars.$error.pattern">Invalid Format</span>
                            </div>
                        </div>                     
                    </div>
                    <div class="col-sm-6" > 
                        <div class="form-group">
                            <label class="control-label col-sm-5">Price Per Bus Trip</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.BusTripe.$invalid && !registerForm.BusTripe.$pristine }">
                                <input type="text" class="form-control" name="BusTripe"  ng-model="pat.BusTripe" placeholder="0.00" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01"  required>
                                <span style="color:red" ng-show="registerForm.BusTripe.$pristine && registerForm.BusTripe.$invalid"> Fare required.</span>
                                <span style="color:red" ng-show="registerForm.BusTripe.$error.pattern">Invalid Format</span>
                            </div>
                        </div>                           
                        <div class="form-group">
                            <label class="control-label col-sm-5">Price Per Taxi Trip</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.TaxiTripe.$invalid && !registerForm.TaxiTripe.$pristine }">
                                <input type="text" class="form-control" name="TaxiTripe"  ng-model="pat.TaxiTripe" placeholder="0.00" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01"  required>                     
                                  <span style="color:red" ng-show="registerForm.TaxiTripe.$pristine && registerForm.TaxiTripe.$invalid"> Fare required.</span>
                                <span style="color:red" ng-show="registerForm.TaxiTripe.$error.pattern">Invalid Format</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">Price Per Car Trip</label>
                            <div class="col-sm-5" ng-class="{'has-error' : registerForm.CarTripe.$invalid && !registerForm.CarTripe.$pristine }">
                                <input type="text" class="form-control" name="CarTripe" placeholder="0.00" ng-model="pat.CarTripe" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01"  required>                     
                                  <span style="color:red" ng-show="registerForm.CarTripe.$pristine && registerForm.CarTripe.$invalid"> Fare required.</span>
                                <span style="color:red" ng-show="registerForm.CarTripe.$error.pattern">Invalid Format</span> 
                            </div>
                        </div>
                                                
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" value="submit"  data-ng-click="save()">Add</button>
            <button type="button" class="btn btn-default" ng-click="close()">Close</button>
        </div>
    </form>
   </script>



     <script type="text/ng-template" id="patientUpdateModalContent.html">
    <!-- Patient Registration Modal -->
        <form class="form-horizontal" name="registerForm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="close()">&times;</button>
                <h4 class="modal-title">{{updateStatus}} User</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-sm-6">                      
                        <div class="form-group" >
                            <label class="control-label col-sm-3">ID No:</label>
                            <div class="col-sm-9" ng-keyup="ValidateIdnumber()" ng-class="{'has-error' : registerForm.IDNo.$invalid && !registerForm.IDNo.$pristine }" >
                                <input type="text" class="form-control" id="id_number" name="id_number"  ng-model="patientData.idnumber" ng-pattern="/^[0-9]{13}$/" ng-readonly="{{truefalse}}" required>                  
                                  <span style="color:red" ng-show="registerForm.id_number.$pristine && registerForm.id_number.$invalid "> ID number is required.</span>
                                 <br /> <span id="errors" style="color:red" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Name:</label>
                            <div class="col-sm-9" ng-class="{'has-error' : registerForm.FirstName.$invalid && !registerForm.FirstName.$pristine }" >
                                <input type="text" class="form-control" id="FirstName" name="FirstName"  ng-model="patientData.name" maxLength='25' ng-pattern="/^[a-zA-Z_-]*$/"  ng-readonly="{{truefalse}}" required>
                                 <span style="color:red" ng-show="registerForm.FirstName.$pristine && registerForm.FirstName.$invalid"> name is required.</span>
                                 <span style="color:red" ng-show="registerForm.FirstName.$error.pattern">incorrect name format</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Surname:</label>
                            <div class="col-sm-9" ng-class="{'has-error' : registerForm.Surname.$invalid && !registerForm.Surname.$pristine }">
                                <input type="text" class="form-control" name="Surname"  data-ng-model="patientData.surname" ng-pattern="/^[a-zA-Z_-]*$/" maxLength='25'  ng-readonly="{{truefalse}}" required >
                                 <span style="color:red" ng-show="registerForm.Surname.$pristine && registerForm.Surname.$invalid"> surname is required.</span>
                                <span style="color:red" ng-show="registerForm.Surname.$error.pattern">incorrect surname format</span>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-6" > 
                        <div class="form-group">
                            <label class="control-label col-sm-3">Email:</label>
                            <div class="col-sm-9" ng-class="{'has-error' : registerForm.Email.$invalid && !registerForm.Email.$pristine }">
                                <input type="email" class="form-control" name="email"  ng-model="patientData.email" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{1,3})$/" required>
                                <span style="color:red" ng-show="registerForm.email.$pristine && registerForm.email.$invalid"> email required.</span>
                                <span style="color:red" ng-show="registerForm.email.$error.pattern"></span>
                            </div>
                        </div>                           
                        <div class="form-group">
                            <label class="control-label col-sm-3">Cell no:</label>
                            <div class="col-sm-9" ng-class="{'has-error' : registerForm.CellNumber.$invalid && !registerForm.CellNumber.$pristine }">
                                <input type="text" class="form-control" name="CellNumber"  ng-model="patientData.cellnumber" ng-pattern="/^[0-0][6-8][0-9]{8}$/" maxLength='10' required>                     
                                  <span style="color:red" ng-show="registerForm.CellNumber.$pristine && registerForm.CellNumber.$invalid"> cell number is required.</span>
                                <span style="color:red" ng-show="registerForm.CellNumber.$error.pattern">cell number is incorrect</span> 
                            </div>
                        </div>
                        
                                                
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" value="submit"  data-ng-click="save()">{{updateStatus}}</button>
            <button type="button" class="btn btn-default" ng-click="close()">Close</button>
        </div>
    </form>
   </script>
      <script src="js/jquery.js" type="text/javascript"></script>
      <script src="js/bootstrap.js" type="text/javascript"></script>
        <!-- angular extentions-->
      <script src="js/angular.js" type="text/javascript"></script> 
      <script src="app.js" type="text/javascript"></script>
      <script src="js/toaster.min.js" type="text/javascript"></script>
      <script src="js/angular-moment.min.js" type="text/javascript"></script>
      <script src="js/angular-route.min.js" type="text/javascript"></script>
      <script src="js/angular-ui-router.js" type="text/javascript"></script>
      <script src="js/ui-bootstrap-tpls.min.js" type="text/javascript"></script>
      <script src="js/dialogs.min.js" type="text/javascript"></script> 
      <script src="js/idvalidator.js" type="text/javascript"></script> 
        <!-- Load controllers -->
     <script src="angular/adminController.js" type="text/javascript"></script>  
     <script src="angular/sharedService.js" type="text/javascript"></script>  
     <script src="angular/loginService.js" type="text/javascript"></script>    

</body>
</html>

<toaster-container></toaster-container>