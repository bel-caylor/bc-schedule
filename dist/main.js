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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L21haW4uanMiLCJtYXBwaW5ncyI6IjtVQUFBO1VBQ0E7Ozs7O1dDREE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxVQUFTQyxDQUFDLEVBQUU7RUFDL0I7RUFDQUEsQ0FBQyxDQUFDLGtCQUFrQixDQUFDLENBQUNDLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUN6QyxNQUFNQyxLQUFLLEdBQUdGLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLFFBQVEsQ0FBQztJQUNwQ0MsT0FBTyxDQUFDQyxHQUFHLENBQUNILEtBQUssQ0FBQztJQUNsQixNQUFNSSxLQUFLLEdBQUdOLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0csSUFBSSxDQUFDLE9BQU8sQ0FBQztJQUNuQ0MsT0FBTyxDQUFDQyxHQUFHLENBQUNDLEtBQUssQ0FBQzs7SUFFbEI7SUFDQSxJQUFJQyxPQUFPLEdBQUdDLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDQyxNQUFNO0lBQ3BDVixDQUFDLENBQUNXLElBQUksQ0FBQztNQUNIQyxHQUFHLEVBQUUsNkJBQTZCLEdBQUdWLEtBQUs7TUFDMUNXLElBQUksRUFBRSxRQUFRO01BQ2RWLElBQUksRUFBRTtRQUNGVyxLQUFLLEVBQUVkLENBQUMsQ0FBQyxZQUFZLENBQUMsQ0FBQ2UsR0FBRyxDQUFDLENBQUM7UUFDNUJULEtBQUssRUFBRUEsS0FBSztRQUNaVSxHQUFHLEVBQUVkO01BQ1QsQ0FBQztNQUNEZSxPQUFPLEVBQUUsU0FBQUEsQ0FBU0MsUUFBUSxFQUFFO1FBQ3hCO1FBQ0FkLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDYSxRQUFRLENBQUM7UUFDckJkLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDLDJCQUEyQixDQUFDO1FBQ3hDTCxDQUFDLENBQUUsUUFBT0UsS0FBTSxFQUFDLENBQUMsQ0FBQ2lCLE1BQU0sQ0FBQyxDQUFDO01BQy9CLENBQUM7TUFDREMsS0FBSyxFQUFFLFNBQUFBLENBQVNBLEtBQUssRUFBRTtRQUNuQjtRQUNBaEIsT0FBTyxDQUFDZ0IsS0FBSyxDQUFDLHFCQUFxQixDQUFDO01BQ3hDO0lBQ0osQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDLEM7Ozs7Ozs7Ozs7QUM5QkYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL2Jvb3RzdHJhcCIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL2JjLXNjaGVkdWxlLy4vanMvaW5kZXguanMiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvLi9zY3NzL3N0eWxlc2hlZXQuc2NzcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBUaGUgcmVxdWlyZSBzY29wZVxudmFyIF9fd2VicGFja19yZXF1aXJlX18gPSB7fTtcblxuIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigkKSB7XHJcbiAgICAvLyBBdHRhY2ggYSBjbGljayBldmVudCB0byB5b3VyIHRyYXNoIGljb24gKGFzc3VtaW5nIGl0IGhhcyBhIHNwZWNpZmljIGNsYXNzIG9yIElEKVxyXG4gICAgJCgnLmRhc2hpY29ucy10cmFzaCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIGNvbnN0IHJvd0lEID0gJCh0aGlzKS5kYXRhKCdyb3ctaWQnKTsgXHJcbiAgICAgICAgY29uc29sZS5sb2cocm93SUQpO1xyXG4gICAgICAgIGNvbnN0IHRhYmxlID0gJCh0aGlzKS5kYXRhKCd0YWJsZScpOyBcclxuICAgICAgICBjb25zb2xlLmxvZyh0YWJsZSk7XHJcbiAgICAgICAgXHJcbiAgICAgICAgLy8gTWFrZSB0aGUgQUpBWCByZXF1ZXN0XHJcbiAgICAgICAgdmFyIGJhc2VVcmwgPSB3aW5kb3cubG9jYXRpb24ub3JpZ2luO1xyXG4gICAgICAgICQuYWpheCh7XHJcbiAgICAgICAgICAgIHVybDogJy93cC1qc29uL2Jjcy92MS9kZWxldGVfcm93LycgKyByb3dJRCxcclxuICAgICAgICAgICAgdHlwZTogJ0RFTEVURScsXHJcbiAgICAgICAgICAgIGRhdGE6IHtcclxuICAgICAgICAgICAgICAgIG5vbmNlOiAkKCcjYmNzX25vbmNlJykudmFsKCksXHJcbiAgICAgICAgICAgICAgICB0YWJsZTogdGFibGUsXHJcbiAgICAgICAgICAgICAgICByb3c6IHJvd0lEXHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgICAgICAgICAvLyBIYW5kbGUgc3VjY2VzcyAoZS5nLiwgcmVtb3ZlIHRoZSByb3cgZnJvbSB0aGUgdGFibGUpXHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhyZXNwb25zZSk7XHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnUm9sZSBkZWxldGVkIHN1Y2Nlc3NmdWxseScpO1xyXG4gICAgICAgICAgICAgICAgJChgI3Jvdy0ke3Jvd0lEfWApLnJlbW92ZSgpO1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oZXJyb3IpIHtcclxuICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBlcnJvclxyXG4gICAgICAgICAgICAgICAgY29uc29sZS5lcnJvcignRXJyb3IgZGVsZXRpbmcgcm9sZScpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSk7IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sIm5hbWVzIjpbImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiLCIkIiwib24iLCJyb3dJRCIsImRhdGEiLCJjb25zb2xlIiwibG9nIiwidGFibGUiLCJiYXNlVXJsIiwid2luZG93IiwibG9jYXRpb24iLCJvcmlnaW4iLCJhamF4IiwidXJsIiwidHlwZSIsIm5vbmNlIiwidmFsIiwicm93Iiwic3VjY2VzcyIsInJlc3BvbnNlIiwicmVtb3ZlIiwiZXJyb3IiXSwic291cmNlUm9vdCI6IiJ9