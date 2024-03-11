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
  $('.dashicons-trash').on('click', function () {
    const roleId = $(this).data('role-id'); // Assuming you set a data attribute for the role ID
    const nonce = $('#my-nonce').val(); // Get the nonce value
    console.log(roleId);

    // Make the AJAX request
    var baseUrl = window.location.origin;
    $.ajax({
      url: '/wp-json/bcs/v1/delete_role/' + roleId,
      type: 'DELETE',
      success: function (response) {
        // Handle success (e.g., remove the row from the table)
        console.log('Role deleted successfully');
        $(`#role-${roleId}`).remove();
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L21haW4uanMiLCJtYXBwaW5ncyI6IjtVQUFBO1VBQ0E7Ozs7O1dDREE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxVQUFTQyxDQUFDLEVBQUU7RUFDL0I7RUFDQUEsQ0FBQyxDQUFDLGtCQUFrQixDQUFDLENBQUNDLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUN6QyxNQUFNQyxNQUFNLEdBQUdGLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLFNBQVMsQ0FBQyxDQUFDLENBQUM7SUFDeEMsTUFBTUMsS0FBSyxHQUFHSixDQUFDLENBQUMsV0FBVyxDQUFDLENBQUNLLEdBQUcsQ0FBQyxDQUFDLENBQUMsQ0FBQztJQUNwQ0MsT0FBTyxDQUFDQyxHQUFHLENBQUNMLE1BQU0sQ0FBQzs7SUFFbkI7SUFDQSxJQUFJTSxPQUFPLEdBQUdDLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDQyxNQUFNO0lBQ3BDWCxDQUFDLENBQUNZLElBQUksQ0FBQztNQUNIQyxHQUFHLEVBQUUsOEJBQThCLEdBQUdYLE1BQU07TUFDNUNZLElBQUksRUFBRSxRQUFRO01BQ2RDLE9BQU8sRUFBRSxTQUFBQSxDQUFTQyxRQUFRLEVBQUU7UUFDeEI7UUFDQVYsT0FBTyxDQUFDQyxHQUFHLENBQUMsMkJBQTJCLENBQUM7UUFDeENQLENBQUMsQ0FBRSxTQUFRRSxNQUFPLEVBQUMsQ0FBQyxDQUFDZSxNQUFNLENBQUMsQ0FBQztNQUNqQyxDQUFDO01BQ0RDLEtBQUssRUFBRSxTQUFBQSxDQUFTQSxLQUFLLEVBQUU7UUFDbkI7UUFDQVosT0FBTyxDQUFDWSxLQUFLLENBQUMscUJBQXFCLENBQUM7TUFDeEM7SUFDSixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMsQzs7Ozs7Ozs7OztBQ3ZCRiIsInNvdXJjZXMiOlsid2VicGFjazovL2JjLXNjaGVkdWxlL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL2JjLXNjaGVkdWxlL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvLi9qcy9pbmRleC5qcyIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS8uL3Njc3Mvc3R5bGVzaGVldC5zY3NzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCQpIHtcclxuICAgIC8vIEF0dGFjaCBhIGNsaWNrIGV2ZW50IHRvIHlvdXIgdHJhc2ggaWNvbiAoYXNzdW1pbmcgaXQgaGFzIGEgc3BlY2lmaWMgY2xhc3Mgb3IgSUQpXHJcbiAgICAkKCcuZGFzaGljb25zLXRyYXNoJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3Qgcm9sZUlkID0gJCh0aGlzKS5kYXRhKCdyb2xlLWlkJyk7IC8vIEFzc3VtaW5nIHlvdSBzZXQgYSBkYXRhIGF0dHJpYnV0ZSBmb3IgdGhlIHJvbGUgSURcclxuICAgICAgICBjb25zdCBub25jZSA9ICQoJyNteS1ub25jZScpLnZhbCgpOyAvLyBHZXQgdGhlIG5vbmNlIHZhbHVlXHJcbiAgICAgICAgY29uc29sZS5sb2cocm9sZUlkKTtcclxuICAgICAgICBcclxuICAgICAgICAvLyBNYWtlIHRoZSBBSkFYIHJlcXVlc3RcclxuICAgICAgICB2YXIgYmFzZVVybCA9IHdpbmRvdy5sb2NhdGlvbi5vcmlnaW47XHJcbiAgICAgICAgJC5hamF4KHtcclxuICAgICAgICAgICAgdXJsOiAnL3dwLWpzb24vYmNzL3YxL2RlbGV0ZV9yb2xlLycgKyByb2xlSWQsXHJcbiAgICAgICAgICAgIHR5cGU6ICdERUxFVEUnLFxyXG4gICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXNwb25zZSkge1xyXG4gICAgICAgICAgICAgICAgLy8gSGFuZGxlIHN1Y2Nlc3MgKGUuZy4sIHJlbW92ZSB0aGUgcm93IGZyb20gdGhlIHRhYmxlKVxyXG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1JvbGUgZGVsZXRlZCBzdWNjZXNzZnVsbHknKTtcclxuICAgICAgICAgICAgICAgICQoYCNyb2xlLSR7cm9sZUlkfWApLnJlbW92ZSgpO1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oZXJyb3IpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBlcnJvclxyXG4gICAgICAgICAgICAgICAgY29uc29sZS5lcnJvcignRXJyb3IgZGVsZXRpbmcgcm9sZScpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSk7IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sIm5hbWVzIjpbImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiLCIkIiwib24iLCJyb2xlSWQiLCJkYXRhIiwibm9uY2UiLCJ2YWwiLCJjb25zb2xlIiwibG9nIiwiYmFzZVVybCIsIndpbmRvdyIsImxvY2F0aW9uIiwib3JpZ2luIiwiYWpheCIsInVybCIsInR5cGUiLCJzdWNjZXNzIiwicmVzcG9uc2UiLCJyZW1vdmUiLCJlcnJvciJdLCJzb3VyY2VSb290IjoiIn0=