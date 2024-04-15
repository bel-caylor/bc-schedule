/******/ (() => { // webpackBootstrap
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*********************!*\
  !*** ./js/index.js ***!
  \*********************/
jQuery(document).ready(function ($) {
  // Attach a click event to your trash icon (assuming it has a specific class or ID)
  $('.dashicons-trash.jquery-delete').on('click', function () {
    const rowID = $(this).data('row-id');
    console.log(rowID);
    const table = $(this).data('table');
    console.log(table);

    // Make the AJAX request
    var baseUrl = window.location.origin;
    $.ajax({
      url: '/wp-json/bcs/v1/delete_row/' + rowID,
      type: 'DELETE',
      data: {
        nonce: $('#bcs_nonce').val(),
        table: table,
        row: rowID
      },
      success: function (response) {
        // Handle success (e.g., remove the row from the table)
        console.log(response);
        console.log('Role deleted successfully');
        $(`#row-${rowID}`).remove();
      },
      error: function (error) {
        // Handle error
        console.error('Error deleting role');
      }
    });
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!******************************!*\
  !*** ./scss/stylesheet.scss ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin

})();

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L2FkbWluLmpzIiwibWFwcGluZ3MiOiI7VUFBQTtVQUNBOzs7OztXQ0RBO1dBQ0E7V0FDQTtXQUNBLHVEQUF1RCxpQkFBaUI7V0FDeEU7V0FDQSxnREFBZ0QsYUFBYTtXQUM3RDs7Ozs7Ozs7OztBQ05BQSxNQUFNLENBQUNDLFFBQVEsQ0FBQyxDQUFDQyxLQUFLLENBQUMsVUFBU0MsQ0FBQyxFQUFFO0VBQy9CO0VBQ0FBLENBQUMsQ0FBQyxnQ0FBZ0MsQ0FBQyxDQUFDQyxFQUFFLENBQUMsT0FBTyxFQUFFLFlBQVc7SUFDdkQsTUFBTUMsS0FBSyxHQUFHRixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNHLElBQUksQ0FBQyxRQUFRLENBQUM7SUFDcENDLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDSCxLQUFLLENBQUM7SUFDbEIsTUFBTUksS0FBSyxHQUFHTixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNHLElBQUksQ0FBQyxPQUFPLENBQUM7SUFDbkNDLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDQyxLQUFLLENBQUM7O0lBRWxCO0lBQ0EsSUFBSUMsT0FBTyxHQUFHQyxNQUFNLENBQUNDLFFBQVEsQ0FBQ0MsTUFBTTtJQUNwQ1YsQ0FBQyxDQUFDVyxJQUFJLENBQUM7TUFDSEMsR0FBRyxFQUFFLDZCQUE2QixHQUFHVixLQUFLO01BQzFDVyxJQUFJLEVBQUUsUUFBUTtNQUNkVixJQUFJLEVBQUU7UUFDRlcsS0FBSyxFQUFFZCxDQUFDLENBQUMsWUFBWSxDQUFDLENBQUNlLEdBQUcsQ0FBQyxDQUFDO1FBQzVCVCxLQUFLLEVBQUVBLEtBQUs7UUFDWlUsR0FBRyxFQUFFZDtNQUNULENBQUM7TUFDRGUsT0FBTyxFQUFFLFNBQUFBLENBQVNDLFFBQVEsRUFBRTtRQUN4QjtRQUNBZCxPQUFPLENBQUNDLEdBQUcsQ0FBQ2EsUUFBUSxDQUFDO1FBQ3JCZCxPQUFPLENBQUNDLEdBQUcsQ0FBQywyQkFBMkIsQ0FBQztRQUN4Q0wsQ0FBQyxDQUFFLFFBQU9FLEtBQU0sRUFBQyxDQUFDLENBQUNpQixNQUFNLENBQUMsQ0FBQztNQUMvQixDQUFDO01BQ0RDLEtBQUssRUFBRSxTQUFBQSxDQUFTQSxLQUFLLEVBQUU7UUFDbkI7UUFDQWhCLE9BQU8sQ0FBQ2dCLEtBQUssQ0FBQyxxQkFBcUIsQ0FBQztNQUN4QztJQUNKLENBQUMsQ0FBQztFQUNOLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyxDOzs7Ozs7Ozs7O0FDOUJGIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS8uL2pzL2luZGV4LmpzIiwid2VicGFjazovL2JjLXNjaGVkdWxlLy4vc2Nzcy9zdHlsZXNoZWV0LnNjc3M/MThkYiJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBUaGUgcmVxdWlyZSBzY29wZVxudmFyIF9fd2VicGFja19yZXF1aXJlX18gPSB7fTtcblxuIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigkKSB7XHJcbiAgICAvLyBBdHRhY2ggYSBjbGljayBldmVudCB0byB5b3VyIHRyYXNoIGljb24gKGFzc3VtaW5nIGl0IGhhcyBhIHNwZWNpZmljIGNsYXNzIG9yIElEKVxyXG4gICAgJCgnLmRhc2hpY29ucy10cmFzaC5qcXVlcnktZGVsZXRlJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3Qgcm93SUQgPSAkKHRoaXMpLmRhdGEoJ3Jvdy1pZCcpOyBcclxuICAgICAgICBjb25zb2xlLmxvZyhyb3dJRCk7XHJcbiAgICAgICAgY29uc3QgdGFibGUgPSAkKHRoaXMpLmRhdGEoJ3RhYmxlJyk7IFxyXG4gICAgICAgIGNvbnNvbGUubG9nKHRhYmxlKTtcclxuICAgICAgICBcclxuICAgICAgICAvLyBNYWtlIHRoZSBBSkFYIHJlcXVlc3RcclxuICAgICAgICB2YXIgYmFzZVVybCA9IHdpbmRvdy5sb2NhdGlvbi5vcmlnaW47XHJcbiAgICAgICAgJC5hamF4KHtcclxuICAgICAgICAgICAgdXJsOiAnL3dwLWpzb24vYmNzL3YxL2RlbGV0ZV9yb3cvJyArIHJvd0lELFxyXG4gICAgICAgICAgICB0eXBlOiAnREVMRVRFJyxcclxuICAgICAgICAgICAgZGF0YToge1xyXG4gICAgICAgICAgICAgICAgbm9uY2U6ICQoJyNiY3Nfbm9uY2UnKS52YWwoKSxcclxuICAgICAgICAgICAgICAgIHRhYmxlOiB0YWJsZSxcclxuICAgICAgICAgICAgICAgIHJvdzogcm93SURcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBzdWNjZXNzIChlLmcuLCByZW1vdmUgdGhlIHJvdyBmcm9tIHRoZSB0YWJsZSlcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSb2xlIGRlbGV0ZWQgc3VjY2Vzc2Z1bGx5Jyk7XHJcbiAgICAgICAgICAgICAgICAkKGAjcm93LSR7cm93SUR9YCkucmVtb3ZlKCk7XHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbihlcnJvcikge1xyXG4gICAgICAgICAgICAgICAgLy8gSGFuZGxlIGVycm9yXHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmVycm9yKCdFcnJvciBkZWxldGluZyByb2xlJyk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG59KTtcclxuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sIm5hbWVzIjpbImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiLCIkIiwib24iLCJyb3dJRCIsImRhdGEiLCJjb25zb2xlIiwibG9nIiwidGFibGUiLCJiYXNlVXJsIiwid2luZG93IiwibG9jYXRpb24iLCJvcmlnaW4iLCJhamF4IiwidXJsIiwidHlwZSIsIm5vbmNlIiwidmFsIiwicm93Iiwic3VjY2VzcyIsInJlc3BvbnNlIiwicmVtb3ZlIiwiZXJyb3IiXSwic291cmNlUm9vdCI6IiJ9