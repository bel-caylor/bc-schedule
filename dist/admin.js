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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9kaXN0L2FkbWluLmpzIiwibWFwcGluZ3MiOiI7VUFBQTtVQUNBOzs7OztXQ0RBO1dBQ0E7V0FDQTtXQUNBLHVEQUF1RCxpQkFBaUI7V0FDeEU7V0FDQSxnREFBZ0QsYUFBYTtXQUM3RDs7Ozs7Ozs7OztBQ05BQSxNQUFNLENBQUNDLFFBQVEsQ0FBQyxDQUFDQyxLQUFLLENBQUMsVUFBU0MsQ0FBQyxFQUFFO0VBQy9CO0VBQ0FBLENBQUMsQ0FBQyxrQkFBa0IsQ0FBQyxDQUFDQyxFQUFFLENBQUMsT0FBTyxFQUFFLFlBQVc7SUFDekMsTUFBTUMsS0FBSyxHQUFHRixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNHLElBQUksQ0FBQyxRQUFRLENBQUM7SUFDcENDLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDSCxLQUFLLENBQUM7SUFDbEIsTUFBTUksS0FBSyxHQUFHTixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNHLElBQUksQ0FBQyxPQUFPLENBQUM7SUFDbkNDLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDQyxLQUFLLENBQUM7O0lBRWxCO0lBQ0EsSUFBSUMsT0FBTyxHQUFHQyxNQUFNLENBQUNDLFFBQVEsQ0FBQ0MsTUFBTTtJQUNwQ1YsQ0FBQyxDQUFDVyxJQUFJLENBQUM7TUFDSEMsR0FBRyxFQUFFLDZCQUE2QixHQUFHVixLQUFLO01BQzFDVyxJQUFJLEVBQUUsUUFBUTtNQUNkVixJQUFJLEVBQUU7UUFDRlcsS0FBSyxFQUFFZCxDQUFDLENBQUMsWUFBWSxDQUFDLENBQUNlLEdBQUcsQ0FBQyxDQUFDO1FBQzVCVCxLQUFLLEVBQUVBLEtBQUs7UUFDWlUsR0FBRyxFQUFFZDtNQUNULENBQUM7TUFDRGUsT0FBTyxFQUFFLFNBQUFBLENBQVNDLFFBQVEsRUFBRTtRQUN4QjtRQUNBZCxPQUFPLENBQUNDLEdBQUcsQ0FBQ2EsUUFBUSxDQUFDO1FBQ3JCZCxPQUFPLENBQUNDLEdBQUcsQ0FBQywyQkFBMkIsQ0FBQztRQUN4Q0wsQ0FBQyxDQUFFLFFBQU9FLEtBQU0sRUFBQyxDQUFDLENBQUNpQixNQUFNLENBQUMsQ0FBQztNQUMvQixDQUFDO01BQ0RDLEtBQUssRUFBRSxTQUFBQSxDQUFTQSxLQUFLLEVBQUU7UUFDbkI7UUFDQWhCLE9BQU8sQ0FBQ2dCLEtBQUssQ0FBQyxxQkFBcUIsQ0FBQztNQUN4QztJQUNKLENBQUMsQ0FBQztFQUNOLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyxDOzs7Ozs7Ozs7O0FDOUJGIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vYmMtc2NoZWR1bGUvd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly9iYy1zY2hlZHVsZS8uL2pzL2luZGV4LmpzIiwid2VicGFjazovL2JjLXNjaGVkdWxlLy4vc2Nzcy9zdHlsZXNoZWV0LnNjc3MiXSwic291cmNlc0NvbnRlbnQiOlsiLy8gVGhlIHJlcXVpcmUgc2NvcGVcbnZhciBfX3dlYnBhY2tfcmVxdWlyZV9fID0ge307XG5cbiIsIi8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uciA9IChleHBvcnRzKSA9PiB7XG5cdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuXHR9XG5cdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG59OyIsImpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oJCkge1xyXG4gICAgLy8gQXR0YWNoIGEgY2xpY2sgZXZlbnQgdG8geW91ciB0cmFzaCBpY29uIChhc3N1bWluZyBpdCBoYXMgYSBzcGVjaWZpYyBjbGFzcyBvciBJRClcclxuICAgICQoJy5kYXNoaWNvbnMtdHJhc2gnKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcclxuICAgICAgICBjb25zdCByb3dJRCA9ICQodGhpcykuZGF0YSgncm93LWlkJyk7IFxyXG4gICAgICAgIGNvbnNvbGUubG9nKHJvd0lEKTtcclxuICAgICAgICBjb25zdCB0YWJsZSA9ICQodGhpcykuZGF0YSgndGFibGUnKTsgXHJcbiAgICAgICAgY29uc29sZS5sb2codGFibGUpO1xyXG4gICAgICAgIFxyXG4gICAgICAgIC8vIE1ha2UgdGhlIEFKQVggcmVxdWVzdFxyXG4gICAgICAgIHZhciBiYXNlVXJsID0gd2luZG93LmxvY2F0aW9uLm9yaWdpbjtcclxuICAgICAgICAkLmFqYXgoe1xyXG4gICAgICAgICAgICB1cmw6ICcvd3AtanNvbi9iY3MvdjEvZGVsZXRlX3Jvdy8nICsgcm93SUQsXHJcbiAgICAgICAgICAgIHR5cGU6ICdERUxFVEUnLFxyXG4gICAgICAgICAgICBkYXRhOiB7XHJcbiAgICAgICAgICAgICAgICBub25jZTogJCgnI2Jjc19ub25jZScpLnZhbCgpLFxyXG4gICAgICAgICAgICAgICAgdGFibGU6IHRhYmxlLFxyXG4gICAgICAgICAgICAgICAgcm93OiByb3dJRFxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXNwb25zZSkge1xyXG4gICAgICAgICAgICAgICAgLy8gSGFuZGxlIHN1Y2Nlc3MgKGUuZy4sIHJlbW92ZSB0aGUgcm93IGZyb20gdGhlIHRhYmxlKVxyXG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2cocmVzcG9uc2UpO1xyXG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1JvbGUgZGVsZXRlZCBzdWNjZXNzZnVsbHknKTtcclxuICAgICAgICAgICAgICAgICQoYCNyb3ctJHtyb3dJRH1gKS5yZW1vdmUoKTtcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKGVycm9yKSB7XHJcbiAgICAgICAgICAgICAgICAvLyBIYW5kbGUgZXJyb3JcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoJ0Vycm9yIGRlbGV0aW5nIHJvbGUnKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcbn0pO1xyXG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsialF1ZXJ5IiwiZG9jdW1lbnQiLCJyZWFkeSIsIiQiLCJvbiIsInJvd0lEIiwiZGF0YSIsImNvbnNvbGUiLCJsb2ciLCJ0YWJsZSIsImJhc2VVcmwiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsIm9yaWdpbiIsImFqYXgiLCJ1cmwiLCJ0eXBlIiwibm9uY2UiLCJ2YWwiLCJyb3ciLCJzdWNjZXNzIiwicmVzcG9uc2UiLCJyZW1vdmUiLCJlcnJvciJdLCJzb3VyY2VSb290IjoiIn0=