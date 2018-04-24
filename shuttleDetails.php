<!DOCTYPE html>
<html lang="en" data-ng-app="shuttle">
<head>
    <title>View Shuttle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/angular-toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style3.css">
</head>
<body ng-controller="shuttleDController.js">
    <div class="col-md-12 header">
       <div class="logo"><h3 style="color:white;font-size:1.8em;text-align:right;">Shuttle Details Section</h3></div> 
    </div>
    <div class="col-md-12 nav-pills-container">
        <ul class="nav nav-pills">
        <li><a href="user.php"><span class="glyphicon glyphicon-home"></span> </a></li>  
            <li class="selected-nav-item"><a href="user-report.php">Reports</a></li>
            <li class="logout-li"><a ng-click="logout()"><div class="glyphicon glyphicon-log-out"></div> Logout</a></li>
        </ul>
    </div>
    <div class="col-md-12 search-and-results-container" ng-repeat="shuttle in shuttleList" > 
        <!-- search results --> 
        <div class="section table-hover-highlight">
            <div class="col-md-12 section-header">
                <div class="concessionID-section">
                    <div class="col-md-2 no-padding-left">
                        <div class="col-md-1 no-padding-left vertical-align-center">                          
                        </div>
                        <div class="col-md-10 no-padding-left">
                            <div class="concession-name">Shuttle Name :{{shuttle.name}}</div>
                           
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="single-print"><i ng-click="openUpdateModal(details)" class="fa fa-edit" aria-hidden="true"></i></div>
                    </div>
                    <div class="col-md-10 no-padding-left">
                        <div class="col-md-2 no-padding-left">
                          Taxi Price:R {{shuttle.taxiprice}}
                        </div>
                        <div class="col-md-3">
                           Car Price: R {{shuttle.privateprice}}
                        </div>
                        <div class="col-md-2">
                           Bus Price: R {{shuttle.busprice}}
                        </div>
                        <div class="col-md-3">
                        Contact Details: R {{shuttle.email}}
                        </div>
                        <div class="col-md-2">
                        <button class="btn btn-info" >Book</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- footer-->
    </div>
  
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
     <script src="angular/shuttleDController.js" type="text/javascript"></script>  
     <script src="angular/sharedService.js" type="text/javascript"></script>  
     <script src="angular/loginService.js" type="text/javascript"></script>    

</body>
</html>

<toaster-container></toaster-container>