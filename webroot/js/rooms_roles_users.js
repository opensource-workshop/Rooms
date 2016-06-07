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
       * リクエストデータ
       *
       * @type {Object.<string>}
       */
      $scope.data = null;

      /**
       * initialize
       */
      $scope.initialize = function(data, formTagDomId) {
        var token = {};
        var elements = $('input[name="data[_Token][unlocked]"]');
        if (! angular.isUndefined(elements[0])) {
          token = {_Token: {unlocked: elements[0].value}};
        }

        $scope.data = angular.extend({
          _Token: {key: ''},
          RolesRoom: {},
          RolesRoomsUser: {},
          User: {id: {}},
          _NetCommonsTime:{}
        }, token, data);

        $scope.actionUrl = $('#' + formTagDomId)[0].action;
      };

      /**
       * appendUser
       */
      $scope.appendUser = function(data) {
        $scope.data['User']['id'] = angular.extend(
            $scope.data['User']['id'], data['User']['id']);
        $scope.data['RolesRoom'] = angular.extend(
            $scope.data['RolesRoom'], data['RolesRoom']);
        $scope.data['RolesRoomsUser'] = angular.extend(
            $scope.data['RolesRoomsUser'], data['RolesRoomsUser']);
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
      $scope.check = function($event) {
        $scope[$event.target.id] = $event.target.checked;
      };

      /**
       * 保存処理
       */
      $scope.save = function(userId, roleKey) {
        var elements = $('#' + roleKey)[0];
        $scope.data['RolesRoom'][userId]['role_key'] = elements.value;
        $scope.$parent.sending = true;

        if (! $('#' + roleKey)[0].value) {
          $scope.data['Role']['key'] = 'delete';
        } else {
          $scope.data['Role']['key'] = $('#' + roleKey)[0].value;
        }
        $scope.data['User']['id'][userId] = '1';

        var elements = $('input[name="data[_Token][fields]"]');
        if (! angular.isUndefined(elements[0])) {
          $scope.data['_Token'] = angular.extend(
              $scope.data['_Token'], {fields: elements[0].value});
        }

        $http.get($scope.baseUrl + '/net_commons/net_commons/csrfToken.json')
          .success(function(token) {
              $scope.data._Token.key = token.data._Token.key;
              //POSTリクエスト
              $http.post($scope.actionUrl,
                  $.param({_method: 'PUT', data: $scope.data}),
                  {cache: false,
                    headers:
                        {'Content-Type': 'application/x-www-form-urlencoded'}
                  }
              ).success(function(data) {
                $scope.flashMessage(data.name, data.class, data.interval);
                $scope.$parent.sending = false;
              }).error(function(data, status) {
                $scope.flashMessage(data['name'], 'danger', 0);
                $scope.$parent.sending = false;
              });
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
