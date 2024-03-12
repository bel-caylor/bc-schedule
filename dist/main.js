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
    console.log(roleId);

    // Make the AJAX request
    var baseUrl = window.location.origin;
    $.ajax({
      url: '/wp-json/bcs/v1/delete_role/' + roleId,
      type: 'DELETE',
      data: {
        nonce: $('#bcs_roles_nonce').val() // Pass the nonce value
      },
      success: function (response) {
        // Handle success (e.g., remove the row from the table)
        console.log(response);
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L21haW4uanMiLCJtYXBwaW5ncyI6IjtVQUFBO1VBQ0E7Ozs7O1dDREE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxVQUFTQyxDQUFDLEVBQUU7RUFDL0I7RUFDQUEsQ0FBQyxDQUFDLGtCQUFrQixDQUFDLENBQUNDLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUN6QyxNQUFNQyxNQUFNLEdBQUdGLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLFNBQVMsQ0FBQyxDQUFDLENBQUM7SUFDeENDLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDSCxNQUFNLENBQUM7O0lBRW5CO0lBQ0EsSUFBSUksT0FBTyxHQUFHQyxNQUFNLENBQUNDLFFBQVEsQ0FBQ0MsTUFBTTtJQUNwQ1QsQ0FBQyxDQUFDVSxJQUFJLENBQUM7TUFDSEMsR0FBRyxFQUFFLDhCQUE4QixHQUFHVCxNQUFNO01BQzVDVSxJQUFJLEVBQUUsUUFBUTtNQUNkVCxJQUFJLEVBQUU7UUFDRlUsS0FBSyxFQUFFYixDQUFDLENBQUMsa0JBQWtCLENBQUMsQ0FBQ2MsR0FBRyxDQUFDLENBQUMsQ0FBQztNQUN2QyxDQUFDO01BQ0RDLE9BQU8sRUFBRSxTQUFBQSxDQUFTQyxRQUFRLEVBQUU7UUFDeEI7UUFDQVosT0FBTyxDQUFDQyxHQUFHLENBQUNXLFFBQVEsQ0FBQztRQUNyQlosT0FBTyxDQUFDQyxHQUFHLENBQUMsMkJBQTJCLENBQUM7UUFDeENMLENBQUMsQ0FBRSxTQUFRRSxNQUFPLEVBQUMsQ0FBQyxDQUFDZSxNQUFNLENBQUMsQ0FBQztNQUNqQyxDQUFDO01BQ0RDLEtBQUssRUFBRSxTQUFBQSxDQUFTQSxLQUFLLEVBQUU7UUFDbkI7UUFDQWQsT0FBTyxDQUFDYyxLQUFLLENBQUMscUJBQXFCLENBQUM7TUFDeEM7SUFDSixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMsQzs7Ozs7Ozs7OztBQzFCRiIsInNvdXJjZXMiOlsid2VicGFjazovL2JjLXNjaGVkdWxlL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL2JjLXNjaGVkdWxlL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvLi9qcy9pbmRleC5qcyIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS8uL3Njc3Mvc3R5bGVzaGVldC5zY3NzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCQpIHtcclxuICAgIC8vIEF0dGFjaCBhIGNsaWNrIGV2ZW50IHRvIHlvdXIgdHJhc2ggaWNvbiAoYXNzdW1pbmcgaXQgaGFzIGEgc3BlY2lmaWMgY2xhc3Mgb3IgSUQpXHJcbiAgICAkKCcuZGFzaGljb25zLXRyYXNoJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3Qgcm9sZUlkID0gJCh0aGlzKS5kYXRhKCdyb2xlLWlkJyk7IC8vIEFzc3VtaW5nIHlvdSBzZXQgYSBkYXRhIGF0dHJpYnV0ZSBmb3IgdGhlIHJvbGUgSURcclxuICAgICAgICBjb25zb2xlLmxvZyhyb2xlSWQpO1xyXG4gICAgICAgIFxyXG4gICAgICAgIC8vIE1ha2UgdGhlIEFKQVggcmVxdWVzdFxyXG4gICAgICAgIHZhciBiYXNlVXJsID0gd2luZG93LmxvY2F0aW9uLm9yaWdpbjtcclxuICAgICAgICAkLmFqYXgoe1xyXG4gICAgICAgICAgICB1cmw6ICcvd3AtanNvbi9iY3MvdjEvZGVsZXRlX3JvbGUvJyArIHJvbGVJZCxcclxuICAgICAgICAgICAgdHlwZTogJ0RFTEVURScsXHJcbiAgICAgICAgICAgIGRhdGE6IHtcclxuICAgICAgICAgICAgICAgIG5vbmNlOiAkKCcjYmNzX3JvbGVzX25vbmNlJykudmFsKCkgLy8gUGFzcyB0aGUgbm9uY2UgdmFsdWVcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBzdWNjZXNzIChlLmcuLCByZW1vdmUgdGhlIHJvdyBmcm9tIHRoZSB0YWJsZSlcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSb2xlIGRlbGV0ZWQgc3VjY2Vzc2Z1bGx5Jyk7XHJcbiAgICAgICAgICAgICAgICAkKGAjcm9sZS0ke3JvbGVJZH1gKS5yZW1vdmUoKTtcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKGVycm9yKSB7XHJcbiAgICAgICAgICAgICAgICAvLyBIYW5kbGUgZXJyb3JcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoJ0Vycm9yIGRlbGV0aW5nIHJvbGUnKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcbn0pOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5IiwiJCIsIm9uIiwicm9sZUlkIiwiZGF0YSIsImNvbnNvbGUiLCJsb2ciLCJiYXNlVXJsIiwid2luZG93IiwibG9jYXRpb24iLCJvcmlnaW4iLCJhamF4IiwidXJsIiwidHlwZSIsIm5vbmNlIiwidmFsIiwic3VjY2VzcyIsInJlc3BvbnNlIiwicmVtb3ZlIiwiZXJyb3IiXSwic291cmNlUm9vdCI6IiJ9