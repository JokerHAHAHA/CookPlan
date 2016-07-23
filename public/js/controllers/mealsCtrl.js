function mealsCtrl ($scope, $rootScope, $http, Upload) {
    
    function load () { 
        // get info from Json about ingredients
        $http.get('./datas/ingredients.json').success(function (data) {
            $scope.ingredients = data;
        });
    }

    // to activate modal materialize
    $(document).ready(function(){
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('.modal-trigger').leanModal();
    });

    // to activate option materialize
    $(document).ready(function() {
        $('select').material_select();
    });


    // =========================UPLOAD=========================
    // upload later on form submit or something similar 
    $scope.submit = function() {
        if ($scope.form.file.$valid && $scope.file) {
            $scope.upload($scope.file);
        }
    };

    // upload on file select or drop 
    $scope.upload = function (file) {
        console.log(file);
        Upload.upload({
            url: 'meals',
            data: {file: file, 'username': $scope.username}
        }).then(function (resp) {
            console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };
    // ========================= END UPLOAD=========================

    load();
}