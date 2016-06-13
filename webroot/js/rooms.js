/**
 * @fileoverview UserRoles Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Rooms controller
 */
NetCommonsApp.controller('RoomsController',
    ['$scope', 'NetCommonsModal', function($scope, NetCommonsModal) {

      /**
       * ルーム詳細表示
       *
       * @return {void}
       */
      $scope.showRoom = function(spaceId, roomId, tab) {
        var url = $scope.baseUrl + '/rooms/rooms/view/' + spaceId + '/' + roomId;
        if (tab) {
          url = url + '?tab=' + tab;
        }
        NetCommonsModal.show($scope, 'RoomsView', url);
      };
    }]);


/**
 * RoomsView modal controller
 */
NetCommonsApp.controller('RoomsView',
    ['$scope', '$uibModalInstance', function($scope, $uibModalInstance) {

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $uibModalInstance.dismiss('cancel');
      };
    }]);
