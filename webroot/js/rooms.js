/**
 * @fileoverview UserRoles Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Rooms controller
 */
NetCommonsApp.controller('RoomsController',
    ['$scope', 'NetCommonsModal', '$location', 'NC3_URL',
      function($scope, NetCommonsModal, $location, NC3_URL) {

        /**
         * ルーム詳細表示
         *
         * @return {void}
         */
        $scope.showRoom = function(spaceId, roomId, tab, isEdit) {
          var url = NC3_URL + '/rooms/rooms/view/' + spaceId + '/' + roomId;
          var search = {};
          if (tab) {
            search['tab'] = tab;
          }
          search['isEdit'] = isEdit;

          $location.search(search);

          NetCommonsModal.show($scope, 'RoomsView', url + $location.url());
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
