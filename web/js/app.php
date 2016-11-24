<script>
    var app = angular.module("myApp", ["ngRoute"]);

    app.config(function ($routeProvider) {
        $routeProvider
                .when("/", {
                    templateUrl: "<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/index"
                })
                .when("/payment-index", {
                    templateUrl: "<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/index"
                })
                .when("/payment-create", {
                    templateUrl: "<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/create"
                })
                .when("/payment-update/:name*", {
                    // templateUrl: "<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/update&id=130"
                    templateUrl: function (urlattr) {
                        return '<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/update&id=' + urlattr.name;
                    },
                })
                .when("/blue", {
                    templateUrl: "blue.htm"
                });
    });


</script>