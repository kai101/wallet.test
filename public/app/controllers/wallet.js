app.controller('walletController', function($scope, $http, API_URL) {
    //retrieve employees listing from API
    $http.get(API_URL + "wallet")
        .then(function(response) {
            console.log(response)
            $scope.wallet = response.data;
        },function(errMsg){ 
            console.log(errMsg)
        });
});