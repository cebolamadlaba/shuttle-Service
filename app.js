var app = angular.module("shuttle", ['ngRoute', 'ui.router', 'ui.bootstrap',  'toaster', 'angularMoment', 'dialogs']);

app.directive('exportTable', function(){
    var link = function ($scope, elm, attr) {
      $scope.$on('export-pdf', function (e, d) {
          elm.tableExport({ type: 'pdf', escape: false });
      });
      $scope.$on('export-excel', function (e, d) {
          elm.tableExport({ type: 'excel', escape: false });
      });
      $scope.$on('export-doc', function (e, d) {
          elm.tableExport({ type: 'doc', escape: false });
      });
      $scope.$on('export-csv', function (e, d) {
          elm.tableExport({ type: 'csv', escape: false });
      });
  }
  return {
      restrict: 'C',
      link: link
  }
  
});


