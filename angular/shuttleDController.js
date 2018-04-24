
app.controller("shuttleDController.js", function ($scope, $http,$modal,sharedService,loginService,$window,$dialogs) {
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
                          
        

                   $scope.shuttleList=function(){
                    $http({
                        url: "getAllShuttleInfo.php",
                        method: "GET"
                        }).then(function (results) {
                        $scope.shuttleList= results.data;                
                    });
            }
            $scope.shuttleList();
            
         
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

