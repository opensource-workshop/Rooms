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
   * All check on click
   */
  $scope.allCheck = function($event) {
    var elements = $('input[type="checkbox"]');

    for (var i = 0; i < elements.length; i++) {
      if (elements[i].name) {
        elements[i].checked = $event.currentTarget.checked;
      }
    }
  };

});
