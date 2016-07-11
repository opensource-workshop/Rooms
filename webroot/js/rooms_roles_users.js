/**
 * @fileoverview RoomsRolesUsers Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * RoomsRolesUsers Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('RoomsRolesUsers',
    ['$scope', '$http', function($scope, $http) {

      /**
       * アクションURL
       */
      $scope.actionUrl = null;

      /**
       * initialize
       */
      $scope.initialize = function(actionUrl) {
        $scope.actionUrl = actionUrl;
      };

      /**
       * チェックボックスの全選択・全解除
       */
      $scope.allCheck = function($event) {
        var elements = $('input[type="checkbox"]');

        for (var i = 0; i < elements.length; i++) {
          if (elements[i].name) {
            elements[i].checked = $event.currentTarget.checked;
            $scope[elements[i].id] = $event.currentTarget.checked;
          }
        }
      };

      /**
       * チェックボックスクリック
       */
      $scope.check = function(id, checked) {
        $scope[id] = checked;
      };

      /**
       * 保存処理
       */
      $scope.save = function(userId, roleKey) {
        var elements = $('#' + roleKey)[0];

        var postData = {
          RolesRoomsUser: {
            user_id: userId,
            role_key: elements.value
          }
        };

        //POSTリクエスト
        $http.post($scope.actionUrl + '.json',
            $.param({_method: 'PUT', data: postData}),
            {cache: false, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
        ).success(function(data) {
        }).error(function(data, status) {
        });
      };

      /**
       * 保存処理
       */
      $scope.delete = function(userId, roleKey) {
        $('#' + roleKey)[0].value = '';
        $scope[roleKey] = '';
        $scope.save(userId, roleKey);
      };

    }]);
