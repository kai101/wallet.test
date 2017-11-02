<!DOCTYPE html>
<html lang="en-US" ng-app="walletApp">
    <head>
        <title>Wallet</title>
        <!-- Load Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
        html, body {
            background-color: #F3F3F3;
            height: 100%;
            max-height: 100%;
            min-height: 100%;
        }
        .wallet-bg{
            background: #ffffff url("/img/wallet.png") no-repeat left top;
            height: 100%;
            width: 100%;
            max-height: 626px;
            max-width: 626px;
        }
        .wallet{
            font-weight: 900;
            max-width: 270px;
            margin-top: 265px;
            margin-left: auto;
            margin-right: auto;
        }
        .figure{
            padding-left: 10px;
        }
        </style>
    </head>
    <body>
        <div class="container wallet-bg" ng-controller="walletController">
            <div class="wallet">
                <div>{{wallet.email}}</div>
                <div>Balance: {{wallet.amount | currency }}</div>
                <p></p>
                <table >
                    <tr ng-repeat="transac in wallet.transactions">
                        <td>{{transac.updated_at | mysql2unix | date : 'MM/dd HH:mm'}}</td>
                        <td class="figure" align="right">{{transac.credit - transac.debit | currency}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/wallet.js') ?>"></script>
    </body>
</html>