/**
 * @fileoverview RoomsRolesUsers Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * RoomsRolesUsers Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('RoomsRolesUsers', function($scope) {

  /**
   * リクエストデータ
   *
   * @type {Object.<string>}
   */
  $scope.data = null;

  /**
   * initialize
   */
  $scope.initialize = function(data) {
    var token = {};
    var elements = $('input[name="_method"]');
    if (! angular.isUndefined(elements[0])) {
      token = angular.extend(token, {_mthod: elements[0].value});
    }
//    var elements = $('input[name="data[_Token][fields]"]');
//    if (! angular.isUndefined(elements[0])) {
//      token = angular.extend(token, {_Token: {fields: elements[0].value}});
//    }
//    var elements = $('input[name="data[_Token][unlocked]"]');
//    if (! angular.isUndefined(elements[0])) {
//      token = angular.extend(token, {_Token: {unlocked: elements[0].value}});
//    }

    $scope.data = angular.extend({
      _Token: {key: ''},
      RolesRoom: {},
      User: {id: {}}
    }, token, data);

    console.log($scope.data);
  };

  /**
   * appendUser
   */
  $scope.appendUser = function(userId, roleKey) {
    if (angular.isUndefined(roleKey)) {
      roleKey = ''
    }
    $scope.data['RolesRoom'][userId] = {
      role_key: roleKey
    };
    $scope.data['User']['id'][userId] = false;

    console.log($scope.data);
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
  $scope.save = function() {
    console.log($scope.data);
  };

});
