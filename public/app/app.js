var app = angular.module('walletApp', [])
    .constant('API_URL', 'http://wallet.test/api/')
    .filter('mysql2unix', function() {
        return function(input) {
            var timestamp = new Date(input.replace(' ', 'T')).getTime();
            console.log(timestamp);
            return timestamp;
        };
    });