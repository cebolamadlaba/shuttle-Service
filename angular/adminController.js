
app.controller("adminController", function ($scope, $http,$modal,sharedService,loginService,$window,$dialogs) {
     "use strict"
  //here logging in assigning object with the information from DB
       $scope.sharedData = sharedService.getData();
        $scope.detail=$scope.sharedData[0];
         if( $scope.detail==undefined){
           window.location.href='index.php'; 
          }
        $scope.username=$scope.sharedData[0].username ;
        $scope.password = $scope.sharedData[0].password;
       var userData= $scope.sharedData[0].idnumber;

      //get single patient information
              $http.post(
                          "patientUser.php", {
                                      'idnumber': userData
                                  }
                        ).then(function (response) {
                                $scope.details= response.data;            
                   });
                          
 
         $scope.openRegModal = function (patients) {
        var modalInstance = $modal.open({
            backdrop: 'static',
            animation: true,
            templateUrl: 'RegModalContent.html',
            controller: 'RegController',
            size: 'lg',
            resolve: {
                    patients: function () {
                        return patients;
                    }
                 }
       });
        modalInstance.result.then(function (selectedItem) {
                       $scope.selected = selectedItem;
                                   
                   }, function () {
        });
   };
      //patient edit
          $scope.openUpdateModal = function (patients) {
              var modalInstance = $modal.open({
                  backdrop: 'static',
                  animation: true,
                  templateUrl: 'patientUpdateModalContent.html',
                  controller: 'patientUpdateController',
                  size: 'lg',
                  resolve: {
                          patients: function () {
                              return patients;
                          }
                        }
              });
              modalInstance.result.then(function (selectedItem) {
                              $scope.selected = selectedItem;
                              $scope.patientsList();     
                          }, function () {
              });
          };
              
          $scope.openShuttleModal = function (patients) {
            var modalInstance = $modal.open({
                backdrop: 'static',
                animation: true,
                templateUrl: 'openShuttleModal.html',
                controller: 'openShuttleModalController',
                size: 'lg',
                resolve: {
                        patients: function () {
                            return patients;
                        }
                      }
            });
            modalInstance.result.then(function (selectedItem) {
                            $scope.selected = selectedItem;
                            $scope.patientsList();     
                        }, function () {
            });
        };

           //get patients list
    $scope.patientsList=function(){
        $http({
            url: "getAllPatientInfo.php",
            method: "GET"
            }).then(function (results) {
            $scope.patients= results.data;                
        });
}
$scope.patientsList();

 //delete user
 $scope.delete =function(patient){
    var dlg = null;
         dlg = $dialogs.confirm("Are you sure you want to make changes?", "");
         dlg.result.then(function (btn) {              
    $http.post(
                  "deleteUser.php", {
                         'idNumber': patient.idnumber,'Active': patient.state
                     }
                 ).then(function (response) {
                     $scope.deletApp = response.data; 
                       $scope.patientsList();                  
                 });
         });
}



          //log out and update logged on as xero
      $scope.logout=function(){               
        $http.post(
            "updateLoggedIn.php", {               
                'logged':"0",'idnumber':$scope.details.idnumber,'currentUser': $scope.details.status 
        }).then(function (response) {
                    $window.sessionStorage.clear();
                    window.location.href='index.php';
         });              
    }

});

app.controller("patientUpdateController", function ($scope, $http, $modalInstance, toaster, $dialogs,patients,loginService,$window) {
  //set form dirty angular validation
  $scope.setDirtyForm = function (form) { angular.forEach(form.$error, function (type) { angular.forEach(type, function (field) { field.$setDirty(); }); }); return form; };
$scope.updateStatus = patients != undefined ? 'Update' : 'Create';
//for readonly on update
if ($scope.updateStatus == 'Update')
    { $scope.truefalse = "true"; }
//assigning selected patient from modal
$scope.patientData=patients;
//ID validation
   $scope.ValidateIdnumber = function(){
       var resultArray =  ValidateID($('#id_number').val());
       if(resultArray[0] === 0){
            var msg ="";
           $.each(resultArray[2], function(index,row){
            msg = row +"<br/>";
           })
          $("#errors").html(msg);
       }
       else{
             $("#errors").html('');
       }
    }
//saving patient file
    $scope.save =function() {

      if ($scope.registerForm.$valid) {
        //extract gender from IDnumber
            
         
        //send data to php file via ajax
            $http.post(
                "insertPatient.php", {
                    'idNo': $scope.patientData.idnumber,'name': $scope.patientData.name, 'surname': $scope.patientData.surname,'cellNo': $scope.patientData.cellnumber, 'email': $scope.patientData.email, 'gender':$scope.patientData.gender,'createDate':$scope.patientData.createDate,'state':$scope.updateStatus
                            }
            ) .then(function (response) {
                if(response.data== 1){
                         toaster.success($scope.patientData.FirstName,'User Registered.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
                 }else if((response.data== 3)){
                     $modalInstance.close();
                     toaster.success('User Updated.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        
               }else{
                     toaster.error('User Already Exist.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
               };
             }); 
           } else {
                    toaster.error(' Please complete all required fields.',
                                                ' ', toaster.options = {
                                                        "positionClass": "toast-top-left",
                                                        "closeButton": true
                                                    });
                        $scope.setDirtyForm($scope.registerForm);
                        $('input.ng-invalid').first().focus();
                    };              
    }     
    $scope.close = function () {
    //
         if ($scope.registerForm.$dirty) {
            var dlg = null;
            dlg = $dialogs.confirm("Unsaved changes will be lost. Continue?", "");
            dlg.result.then(function (btn) {
                $modalInstance.dismiss('cancel');
            }, function (btn) { });
        } else { $modalInstance.dismiss('cancel'); }
    }

});

app.controller("RegController", function ($scope, $http, $modalInstance,patients, toaster, $dialogs,sharedService,loginService,$window) {
    "use strict"
    $scope.sharedData = sharedService.getData();
    //set form dirty angular validation
  $scope.setDirtyForm = function (form) { angular.forEach(form.$error, function (type) { angular.forEach(type, function (field) { field.$setDirty(); }); }); return form; };
$scope.updateStatus = patients != undefined ? 'Update' : 'Register';
//for readonly on update
if ($scope.updateStatus == 'Update')
    { $scope.truefalse = "true"; }
//assigning selected patient from modal
$scope.patientData=patients;
//ID validation
   $scope.ValidateIdnumber = function(){
       var resultArray =  ValidateID($('#id_number').val());
       if(resultArray[0] === 0){
            var msg ="";
           $.each(resultArray[2], function(index,row){
            msg = row +"<br/>";
           })
          $("#errors").html(msg);
       }
       else{
             $("#errors").html('');
       }
    }

//saving patient file
    $scope.save =function() {

      if ($scope.registerForm.$valid) {
        //extract gender from IDnumber
            var saIds =$scope.patientData.idNumber;
            var saId=(saIds.substr ( 6  , 4));
            if ((saId > 4999) & (saId < 10000)){
				 $scope.patientData.gender='Male';
			}else
            {
                $scope.patientData.gender='Female'; 
            }
            //get current date 
            var todayDate =new Date();
           var selDate = todayDate.toISOString();
            $scope.patientData.createDate=selDate.substring(0,10);
            $scope.patientData.pID=saIds.substring(7,13);
            
        //send data to php file via ajax
            $http.post(
                "insertPatientAdmin.php", {
                    'idNo': $scope.patientData.idNumber,'name': $scope.patientData.FirstName, 'surname': $scope.patientData.Surname,'cellNo': $scope.patientData.CellNumber, 'email': $scope.patientData.Email, 'gender':$scope.patientData.gender,'createDate':$scope.patientData.createDate,'state':$scope.updateStatus,'status':$scope.patientData.logValue
                            }
            ) .then(function (response) {
                if(response.data== 1){
                         toaster.success($scope.patientData.FirstName,'User Registered.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
                 }else if((response.data== 3)){
                     $modalInstance.close();
                     toaster.success('user Updated.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        
               }else{
                     toaster.error('user Already Exist.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
               };
             }); 
           } else {
                    toaster.error(' Please complete all required fields.',
                                                ' ', toaster.options = {
                                                        "positionClass": "toast-top-left",
                                                        "closeButton": true
                                                    });
                        $scope.setDirtyForm($scope.registerForm);
                        $('input.ng-invalid').first().focus();
                    };              
    }     
    $scope.close = function () {
    //
         if ($scope.registerForm.$dirty) {
            var dlg = null;
            dlg = $dialogs.confirm("Are you sure you want to close ?", "");
            dlg.result.then(function (btn) {
                $modalInstance.dismiss('cancel');
            }, function (btn) { });
        } else { $modalInstance.dismiss('cancel'); }
    }
});   

app.controller("openShuttleModalController", function ($scope, $http, $modalInstance,patients, toaster, $dialogs,sharedService,loginService,$window) {
    "use strict"
    $scope.sharedData = sharedService.getData();
    //set form dirty angular validation
  $scope.setDirtyForm = function (form) { angular.forEach(form.$error, function (type) { angular.forEach(type, function (field) { field.$setDirty(); }); }); return form; };
$scope.updateStatus = patients != undefined ? 'Update' : 'Register';
//for readonly on update
if ($scope.updateStatus == 'Update')
    { $scope.truefalse = "true"; }
//assigning selected patient from modal
$scope.patientData=patients;
//ID validation
  

//saving patient file
    $scope.save =function() {

      if ($scope.registerForm.$valid) {
        
            
        //send data to php file via ajax
         $http.post(
                "insertShuttle.php", {
                    'idNo': $scope.patientData.idnumber,'name': $scope.pat.FirstName,'email': $scope.patientData.email, 'Taxis': $scope.pat.Taxis,'Buses': $scope.pat.Buses, 'Cars':$scope.pat.Cars, 'BusTripe':$scope.pat.BusTripe,'TaxiTripe':$scope.pat.TaxiTripe,'CarTripe':$scope.pat.CarTripe
                            }
            ) .then(function (response) {
                if(response.data== 1){
                         toaster.success($scope.patientData.name,'Shuttle Service Registered.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
                 }else if((response.data== 3)){
                     $modalInstance.close();
                     toaster.success('Shuttle Service Updated.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        
               }else{
                     toaster.error('Shuttle Service Already Exist.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                        $modalInstance.close();
               };
             }); 
           } else {
                    toaster.error(' Please complete all required fields.',
                                                ' ', toaster.options = {
                                                        "positionClass": "toast-top-left",
                                                        "closeButton": true
                                                    });
                        $scope.setDirtyForm($scope.registerForm);
                        $('input.ng-invalid').first().focus();
                    };              
    }     
    $scope.close = function () {
    //
         if ($scope.registerForm.$dirty) {
            var dlg = null;
            dlg = $dialogs.confirm("Are you sure you want to close ?", "");
            dlg.result.then(function (btn) {
                $modalInstance.dismiss('cancel');
            }, function (btn) { });
        } else { $modalInstance.dismiss('cancel'); }
    }
});
