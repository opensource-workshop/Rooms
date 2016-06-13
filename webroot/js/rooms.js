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
      $scope.showRoom = function(spaceId, roomId) {
        NetCommonsModal.show(
            $scope, 'RoomsView',
            $scope.baseUrl + '/rooms/rooms/view/' + spaceId + '/' + roomId
        );
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
