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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L21haW4uanMiLCJtYXBwaW5ncyI6IjtVQUFBO1VBQ0E7Ozs7O1dDREE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxVQUFTQyxDQUFDLEVBQUU7RUFDL0I7RUFDQUEsQ0FBQyxDQUFDLGtCQUFrQixDQUFDLENBQUNDLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUN6QyxNQUFNQyxLQUFLLEdBQUdGLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLFFBQVEsQ0FBQztJQUNwQ0MsT0FBTyxDQUFDQyxHQUFHLENBQUNILEtBQUssQ0FBQztJQUNsQixNQUFNSSxLQUFLLEdBQUdOLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLE9BQU8sQ0FBQztJQUNuQ0MsT0FBTyxDQUFDQyxHQUFHLENBQUNDLEtBQUssQ0FBQzs7SUFFbEI7SUFDQSxJQUFJQyxPQUFPLEdBQUdDLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDQyxNQUFNO0lBQ3BDVixDQUFDLENBQUNXLElBQUksQ0FBQztNQUNIQyxHQUFHLEVBQUUsNkJBQTZCLEdBQUdWLEtBQUs7TUFDMUNXLElBQUksRUFBRSxRQUFRO01BQ2RWLElBQUksRUFBRTtRQUNGVyxLQUFLLEVBQUVkLENBQUMsQ0FBQyxZQUFZLENBQUMsQ0FBQ2UsR0FBRyxDQUFDLENBQUM7UUFDNUJULEtBQUssRUFBRUEsS0FBSztRQUNaVSxHQUFHLEVBQUVkO01BQ1QsQ0FBQztNQUNEZSxPQUFPLEVBQUUsU0FBQUEsQ0FBU0MsUUFBUSxFQUFFO1FBQ3hCO1FBQ0FkLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDYSxRQUFRLENBQUM7UUFDckJkLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDLDJCQUEyQixDQUFDO1FBQ3hDTCxDQUFDLENBQUUsUUFBT0UsS0FBTSxFQUFDLENBQUMsQ0FBQ2lCLE1BQU0sQ0FBQyxDQUFDO01BQy9CLENBQUM7TUFDREMsS0FBSyxFQUFFLFNBQUFBLENBQVNBLEtBQUssRUFBRTtRQUNuQjtRQUNBaEIsT0FBTyxDQUFDZ0IsS0FBSyxDQUFDLHFCQUFxQixDQUFDO01BQ3hDO0lBQ0osQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDLEM7Ozs7Ozs7Ozs7QUM5QkYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL2Jvb3RzdHJhcCIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL2JjLXNjaGVkdWxlLy4vanMvaW5kZXguanMiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvLi9zY3NzL3N0eWxlc2hlZXQuc2Nzcz8xOGRiIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCQpIHtcclxuICAgIC8vIEF0dGFjaCBhIGNsaWNrIGV2ZW50IHRvIHlvdXIgdHJhc2ggaWNvbiAoYXNzdW1pbmcgaXQgaGFzIGEgc3BlY2lmaWMgY2xhc3Mgb3IgSUQpXHJcbiAgICAkKCcuZGFzaGljb25zLXRyYXNoJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3Qgcm93SUQgPSAkKHRoaXMpLmRhdGEoJ3Jvdy1pZCcpOyBcclxuICAgICAgICBjb25zb2xlLmxvZyhyb3dJRCk7XHJcbiAgICAgICAgY29uc3QgdGFibGUgPSAkKHRoaXMpLmRhdGEoJ3RhYmxlJyk7IFxyXG4gICAgICAgIGNvbnNvbGUubG9nKHRhYmxlKTtcclxuICAgICAgICBcclxuICAgICAgICAvLyBNYWtlIHRoZSBBSkFYIHJlcXVlc3RcclxuICAgICAgICB2YXIgYmFzZVVybCA9IHdpbmRvdy5sb2NhdGlvbi5vcmlnaW47XHJcbiAgICAgICAgJC5hamF4KHtcclxuICAgICAgICAgICAgdXJsOiAnL3dwLWpzb24vYmNzL3YxL2RlbGV0ZV9yb3cvJyArIHJvd0lELFxyXG4gICAgICAgICAgICB0eXBlOiAnREVMRVRFJyxcclxuICAgICAgICAgICAgZGF0YToge1xyXG4gICAgICAgICAgICAgICAgbm9uY2U6ICQoJyNiY3Nfbm9uY2UnKS52YWwoKSxcclxuICAgICAgICAgICAgICAgIHRhYmxlOiB0YWJsZSxcclxuICAgICAgICAgICAgICAgIHJvdzogcm93SURcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBzdWNjZXNzIChlLmcuLCByZW1vdmUgdGhlIHJvdyBmcm9tIHRoZSB0YWJsZSlcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSb2xlIGRlbGV0ZWQgc3VjY2Vzc2Z1bGx5Jyk7XHJcbiAgICAgICAgICAgICAgICAkKGAjcm93LSR7cm93SUR9YCkucmVtb3ZlKCk7XHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbihlcnJvcikge1xyXG4gICAgICAgICAgICAgICAgLy8gSGFuZGxlIGVycm9yXHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmVycm9yKCdFcnJvciBkZWxldGluZyByb2xlJyk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG59KTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsialF1ZXJ5IiwiZG9jdW1lbnQiLCJyZWFkeSIsIiQiLCJvbiIsInJvd0lEIiwiZGF0YSIsImNvbnNvbGUiLCJsb2ciLCJ0YWJsZSIsImJhc2VVcmwiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsIm9yaWdpbiIsImFqYXgiLCJ1cmwiLCJ0eXBlIiwibm9uY2UiLCJ2YWwiLCJyb3ciLCJzdWNjZXNzIiwicmVzcG9uc2UiLCJyZW1vdmUiLCJlcnJvciJdLCJzb3VyY2VSb290IjoiIn0=