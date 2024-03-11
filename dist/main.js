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

    // Make the AJAX request
    $.ajax({
      url: myAjax.ajaxurl,
      type: 'POST',
      data: {
        action: 'delete_role',
        nonce: nonce,
        role_id: roleId
      },
      success: function (response) {
        // Handle success (e.g., remove the row from the table)
        console.log('Role deleted successfully');
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L21haW4uanMiLCJtYXBwaW5ncyI6IjtVQUFBO1VBQ0E7Ozs7O1dDREE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxVQUFTQyxDQUFDLEVBQUU7RUFDL0I7RUFDQUEsQ0FBQyxDQUFDLGtCQUFrQixDQUFDLENBQUNDLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUN6QyxNQUFNQyxNQUFNLEdBQUdGLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLFNBQVMsQ0FBQyxDQUFDLENBQUM7SUFDeEMsTUFBTUMsS0FBSyxHQUFHSixDQUFDLENBQUMsV0FBVyxDQUFDLENBQUNLLEdBQUcsQ0FBQyxDQUFDLENBQUMsQ0FBQzs7SUFFcEM7SUFDQUwsQ0FBQyxDQUFDTSxJQUFJLENBQUM7TUFDSEMsR0FBRyxFQUFFQyxNQUFNLENBQUNDLE9BQU87TUFDbkJDLElBQUksRUFBRSxNQUFNO01BQ1pQLElBQUksRUFBRTtRQUNGUSxNQUFNLEVBQUUsYUFBYTtRQUNyQlAsS0FBSyxFQUFFQSxLQUFLO1FBQ1pRLE9BQU8sRUFBRVY7TUFDYixDQUFDO01BQ0RXLE9BQU8sRUFBRSxTQUFBQSxDQUFTQyxRQUFRLEVBQUU7UUFDeEI7UUFDQUMsT0FBTyxDQUFDQyxHQUFHLENBQUMsMkJBQTJCLENBQUM7TUFDNUMsQ0FBQztNQUNEQyxLQUFLLEVBQUUsU0FBQUEsQ0FBU0EsS0FBSyxFQUFFO1FBQ25CO1FBQ0FGLE9BQU8sQ0FBQ0UsS0FBSyxDQUFDLHFCQUFxQixDQUFDO01BQ3hDO0lBQ0osQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDLEM7Ozs7Ozs7Ozs7QUN6QkYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL2Jvb3RzdHJhcCIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL2JjLXNjaGVkdWxlLy4vanMvaW5kZXguanMiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvLi9zY3NzL3N0eWxlc2hlZXQuc2Nzcz8xOGRiIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCQpIHtcclxuICAgIC8vIEF0dGFjaCBhIGNsaWNrIGV2ZW50IHRvIHlvdXIgdHJhc2ggaWNvbiAoYXNzdW1pbmcgaXQgaGFzIGEgc3BlY2lmaWMgY2xhc3Mgb3IgSUQpXHJcbiAgICAkKCcuZGFzaGljb25zLXRyYXNoJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3Qgcm9sZUlkID0gJCh0aGlzKS5kYXRhKCdyb2xlLWlkJyk7IC8vIEFzc3VtaW5nIHlvdSBzZXQgYSBkYXRhIGF0dHJpYnV0ZSBmb3IgdGhlIHJvbGUgSURcclxuICAgICAgICBjb25zdCBub25jZSA9ICQoJyNteS1ub25jZScpLnZhbCgpOyAvLyBHZXQgdGhlIG5vbmNlIHZhbHVlXHJcblxyXG4gICAgICAgIC8vIE1ha2UgdGhlIEFKQVggcmVxdWVzdFxyXG4gICAgICAgICQuYWpheCh7XHJcbiAgICAgICAgICAgIHVybDogbXlBamF4LmFqYXh1cmwsXHJcbiAgICAgICAgICAgIHR5cGU6ICdQT1NUJyxcclxuICAgICAgICAgICAgZGF0YToge1xyXG4gICAgICAgICAgICAgICAgYWN0aW9uOiAnZGVsZXRlX3JvbGUnLFxyXG4gICAgICAgICAgICAgICAgbm9uY2U6IG5vbmNlLFxyXG4gICAgICAgICAgICAgICAgcm9sZV9pZDogcm9sZUlkXHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgICAgICAgICAvLyBIYW5kbGUgc3VjY2VzcyAoZS5nLiwgcmVtb3ZlIHRoZSByb3cgZnJvbSB0aGUgdGFibGUpXHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnUm9sZSBkZWxldGVkIHN1Y2Nlc3NmdWxseScpO1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oZXJyb3IpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBlcnJvclxyXG4gICAgICAgICAgICAgICAgY29uc29sZS5lcnJvcignRXJyb3IgZGVsZXRpbmcgcm9sZScpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSk7IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sIm5hbWVzIjpbImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiLCIkIiwib24iLCJyb2xlSWQiLCJkYXRhIiwibm9uY2UiLCJ2YWwiLCJhamF4IiwidXJsIiwibXlBamF4IiwiYWpheHVybCIsInR5cGUiLCJhY3Rpb24iLCJyb2xlX2lkIiwic3VjY2VzcyIsInJlc3BvbnNlIiwiY29uc29sZSIsImxvZyIsImVycm9yIl0sInNvdXJjZVJvb3QiOiIifQ==