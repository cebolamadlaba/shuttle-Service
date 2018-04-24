
app.controller("indexController", function ($scope, $http,$modal,sharedService,loginService,$window) {
    "use strict"

 $scope.openlogInModal = function ( ) {
        var modalInstance = $modal.open({
            backdrop: 'static',
            animation: true,
            templateUrl: 'logInModalContent.html',
            controller: 'adminlogInController',
            size: 'md'
        });
    };



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

});

app.controller("adminlogInController", function ($scope, $http, $modalInstance, toaster, $dialogs,sharedService,loginService,$window) {
 "use strict"
    $scope.setDirtyForm = function (form) { angular.forEach(form.$error, function (type) { angular.forEach(type, function (field) { field.$setDirty(); }); }); return form; };
 $scope.showError = null;
 $scope.errors=null;
  
    $scope.saveLogIn = function (logInData) {

     if ($scope.logInForm.$valid) {
          if(logInData.forgot=='Y'){
             $http.post(
                "forgotPassword.php", {
                          'username': logInData.username,'logValue': logInData.logValue
                            }
                            
                        ).then(function (response) {
                           if(response.data == 2){
                                 $scope.errors= "No Record For"+" "+ logInData.logValue +" "+ " Was Found";
                                 $scope.showError = 1;
                            }else if(response.data == 1){
                                
                                 toaster.success('PLease Check Your Mail.', ' ',
                                    toaster.options = {
                                        "positionClass": "toast-top-center",
                                        "closeButton": true
                                    });
                            }else{
                                 $scope.errors= "Unknown Errror Occur Please Contact admin";
                                 $scope.showError = 1;
                            }

                        })              
           }else{
                loginService.logIn(logInData).then(function (response) {
                $modalInstance.close();
             if(response.data ==1){
                  toaster.error('Wrong Password Entered',
                                           '', toaster.options = {
                                "positionClass": "toast-top-right",
                                     "closeButton": true
                              });
            }else if(response.data.password==$scope.data.password && response.data.email==$scope.data.username){
                     $scope.dataToShare = [];                                          
                          $scope.dataToShare = response.data;
                         sharedService.addData($scope.dataToShare);
                         if($scope.dataToShare.status=="User"){
                            if($scope.dataToShare.logged=="0"){
                                $scope.dataToShare.logged=="1";
                                $http.post(
                                    "updateLoggedIn.php", {               
                                        'logged':"1",'idnumber':$scope.dataToShare.idnumber,'currentUser': $scope.dataToShare.status 
                                }).then(function (response) {
                                    window.location.href='user.php';  
                                });
                            }else{
                                 toaster.error('User already signed in',
                                             '', toaster.options = {
                                             "positionClass": "toast-top-right",
                                            "closeButton": true
                                });                               
                            } 
                            
                         }else if($scope.dataToShare.status=="Admin") {
                            if($scope.dataToShare.logged=="0"){
                                $scope.dataToShare.logged=="1";
                                $http.post(
                                    "updateLoggedIn.php", {               
                                        'logged':"1",'idnumber':$scope.dataToShare.idnumber,'currentUser': $scope.dataToShare.status 
                                }).then(function (response) {
                                 window.location.href='admin.php'; 
                                });
                            }else{
                                 toaster.error('User already signed in',
                                             '', toaster.options = {
                                             "positionClass": "toast-top-right",
                                            "closeButton": true
                                });                               
                            }                             
                         }else if($scope.dataToShare.status=="Shuttle") {
                            if($scope.dataToShare.logged=="0"){
                                $scope.dataToShare.logged=="1";
                                $http.post(
                                    "updateLoggedIn.php", {               
                                        'logged':"1",'idnumber':$scope.dataToShare.idnumber,'currentUser': $scope.dataToShare.status 
                                }).then(function (response) {
                                  window.location.href='shuttle.php';  
                                });
                            }else{
                                 toaster.error('User already signed in',
                                             '', toaster.options = {
                                             "positionClass": "toast-top-right",
                                            "closeButton": true
                                });                               
                            } 
                            
                         }else if($scope.dataToShare.status=="Pharmacist") {
                            if($scope.dataToShare.logged=="0"){
                                $scope.dataToShare.logged=="1";
                                $http.post(
                                    "updateLoggedIn.php", {               
                                        'logged':"1",'idNumber':$scope.dataToShare.idNumber,'currentUser': $scope.dataToShare.role 
                                                }
                                ).then(function (response) {
                                   window.location.href='pharmacist.php';  
                                });
                            }else{
                                 toaster.error('User already signed in',
                                             '', toaster.options = {
                                             "positionClass": "toast-top-right",
                                            "closeButton": true
                                });                               
                            } 
                            
                         }                                                               
            }else if(response.data ==2){
                 toaster.error('Wrong Username entered',
                                           '', toaster.options = {
                                "positionClass": "toast-top-right",
                                     "closeButton": true
                              });
            }else{

                 toaster.error('The Username and password entered does not match',
                                           '', toaster.options = {
                                "positionClass": "toast-top-right",
                                     "closeButton": true
                              });
            }

       
            }, function (error) {                    
                toaster.error(' Log In Failed.',
                                            'Failed!', toaster.options = {
                                    "positionClass": "toast-top-center",
                                        "closeButton": true
                                });
                console.error(error);
            });
        } 
    };
  }
  
    $scope.close = function () {
        if ($scope.logInForm.$dirty) {
            var dlg = null;
            dlg = $dialogs.confirm("Are you sure you want to exit ?", "");
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
                "insertPatient.php", {
                    'idNo': $scope.patientData.idNumber,'name': $scope.patientData.FirstName, 'surname': $scope.patientData.Surname,'cellNo': $scope.patientData.CellNumber, 'email': $scope.patientData.Email, 'gender':$scope.patientData.gender,'createDate':$scope.patientData.createDate,'state':$scope.updateStatus
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