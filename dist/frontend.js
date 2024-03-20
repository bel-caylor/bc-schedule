/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./js/frontend/index.js ***!
  \******************************/
(function ($) {
  $(document).ready(function () {
    $('#excluded-dates-form').on('submit', function (e) {
      e.preventDefault();
      var formData = new FormData();
      var name = $('#name').val();
      var email = $('#email').val();
      var dates = $('#dates').val();
      console.log(formData);
      // Check if formData is empty (for debugging)
      if (!formData) {
        console.error('formData is empty!');
      } else {
        fetch('/wp-json/bcs/v1/process-bcs-add-excluded-dates', {
          method: 'POST',
          // body: formData,
          body: JSON.stringify({
            name,
            email,
            dates
          })
        }).then(response => response.json()).then(data => {
          console.log(data);
          if (data.success) {
            // Handle successful form submission
            console.log(data.message);
          } else {
            // Handle form submission error
            console.log(data.message);
          }
        }).catch(error => {
          // Handle fetch error
          console.error('Fetch error:', error);
        });
      }
    });
  });
})(jQuery);
const excludedDatesContainer = document.getElementById('excludedDates');
const hiddenDatesInput = document.getElementById('dates');
const excludedDateInput = document.getElementById('excludedDate');
const addDateButton = document.getElementById('addDateButton');
const addDate = () => {
  const selectedDate = excludedDateInput.value;

  // Validate date (optional)
  // You can add code to validate the selected date format here

  // Update the hidden input with comma-separated selected dates
  const currentDates = hiddenDatesInput.value;
  let newDates = '';
  if (currentDates) {
    newDates = currentDates + ',';
  }
  newDates += selectedDate;
  hiddenDatesInput.value = newDates;

  // Display the selected date in the container (optional)
  const dateLabel = document.createElement('span');
  dateLabel.textContent = selectedDate;
  excludedDatesContainer.appendChild(dateLabel);

  // Clear the date input for the next selection
  excludedDateInput.value = '';
};
addDateButton.addEventListener('click', addDate);

// const form = document.getElementById('excluded-dates-form');

// form.addEventListener('submit', async (event) => {
//   event.preventDefault();

//   const name = document.getElementById('name').value;
//   const email = document.getElementById('email').value;
//   const dates = document.getElementById('dates').value;

//   const response = await fetch(`${your_website_url}/wp-json/bcs/v1/process-bcs-add-excluded-dates`, {
//     method: 'POST',
//     headers: {
//       'Content-Type': 'application/json'
//     },
//     body: JSON.stringify({
//       name,
//       email,
//       dates
//     })
//   });

//   if (!response.ok) {
//     console.error(`Error: ${response.status}`);
//     alert('Error adding dates!');
//     return;
//   }

//   const data = await response.json();
//   alert(data.message);
// });
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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TixZQUFZO0VBQ3BDTixzQkFBc0IsQ0FBQ2EsV0FBVyxDQUFDSCxTQUFTLENBQUM7O0VBRTdDO0VBQ0FQLGlCQUFpQixDQUFDSSxLQUFLLEdBQUcsRUFBRTtBQUM5QixDQUFDO0FBRURILGFBQWEsQ0FBQ1UsZ0JBQWdCLENBQUMsT0FBTyxFQUFFVCxPQUFPLENBQUM7O0FBSWhEOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsTSIsInNvdXJjZXMiOlsid2VicGFjazovL2JjLXNjaGVkdWxlLy4vanMvZnJvbnRlbmQvaW5kZXguanMiXSwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCQpIHtcclxuICAgICQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICQoJyNleGNsdWRlZC1kYXRlcy1mb3JtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICBcclxuICAgICAgICAgICAgdmFyIGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCk7XHJcbiAgICAgICAgICAgIHZhciBuYW1lID0gJCgnI25hbWUnKS52YWwoKTtcclxuICAgICAgICAgICAgdmFyIGVtYWlsID0gJCgnI2VtYWlsJykudmFsKCk7XHJcbiAgICAgICAgICAgIHZhciBkYXRlcyA9ICQoJyNkYXRlcycpLnZhbCgpO1xyXG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XHJcbiAgICAgICAgICAgIC8vIENoZWNrIGlmIGZvcm1EYXRhIGlzIGVtcHR5IChmb3IgZGVidWdnaW5nKVxyXG4gICAgICAgICAgICBpZiAoIWZvcm1EYXRhKSB7XHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmVycm9yKCdmb3JtRGF0YSBpcyBlbXB0eSEnKTtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIGZldGNoKCcvd3AtanNvbi9iY3MvdjEvcHJvY2Vzcy1iY3MtYWRkLWV4Y2x1ZGVkLWRhdGVzJywge1xyXG4gICAgICAgICAgICAgICAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICAgICAgICAgICAgICAgIC8vIGJvZHk6IGZvcm1EYXRhLFxyXG4gICAgICAgICAgICAgICAgICAgIGJvZHk6IEpTT04uc3RyaW5naWZ5KHtcclxuICAgICAgICAgICAgICAgICAgICBuYW1lLFxyXG4gICAgICAgICAgICAgICAgICAgIGVtYWlsLFxyXG4gICAgICAgICAgICAgICAgICAgIGRhdGVzXHJcbiAgICAgICAgICAgICAgICAgICAgfSlcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgICAudGhlbihyZXNwb25zZSA9PiByZXNwb25zZS5qc29uKCkpXHJcbiAgICAgICAgICAgICAgICAudGhlbihkYXRhID0+IHtcclxuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhkYXRhKTtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZGF0YS5zdWNjZXNzKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBzdWNjZXNzZnVsIGZvcm0gc3VibWlzc2lvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhkYXRhLm1lc3NhZ2UpO1xyXG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIEhhbmRsZSBmb3JtIHN1Ym1pc3Npb24gZXJyb3JcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coZGF0YS5tZXNzYWdlKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcclxuICAgICAgICAgICAgICAgICAgICAvLyBIYW5kbGUgZmV0Y2ggZXJyb3JcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29uc29sZS5lcnJvcignRmV0Y2ggZXJyb3I6JywgZXJyb3IpO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSkoalF1ZXJ5KTtcclxuXHJcbmNvbnN0IGV4Y2x1ZGVkRGF0ZXNDb250YWluZXIgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZXhjbHVkZWREYXRlcycpO1xyXG5jb25zdCBoaWRkZW5EYXRlc0lucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2RhdGVzJyk7XHJcbmNvbnN0IGV4Y2x1ZGVkRGF0ZUlucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2V4Y2x1ZGVkRGF0ZScpO1xyXG5jb25zdCBhZGREYXRlQnV0dG9uID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2FkZERhdGVCdXR0b24nKTtcclxuXHJcbmNvbnN0IGFkZERhdGUgPSAoKSA9PiB7XHJcbiAgY29uc3Qgc2VsZWN0ZWREYXRlID0gZXhjbHVkZWREYXRlSW5wdXQudmFsdWU7XHJcblxyXG4gIC8vIFZhbGlkYXRlIGRhdGUgKG9wdGlvbmFsKVxyXG4gIC8vIFlvdSBjYW4gYWRkIGNvZGUgdG8gdmFsaWRhdGUgdGhlIHNlbGVjdGVkIGRhdGUgZm9ybWF0IGhlcmVcclxuXHJcbiAgLy8gVXBkYXRlIHRoZSBoaWRkZW4gaW5wdXQgd2l0aCBjb21tYS1zZXBhcmF0ZWQgc2VsZWN0ZWQgZGF0ZXNcclxuICBjb25zdCBjdXJyZW50RGF0ZXMgPSBoaWRkZW5EYXRlc0lucHV0LnZhbHVlO1xyXG4gIGxldCBuZXdEYXRlcyA9ICcnO1xyXG4gIGlmIChjdXJyZW50RGF0ZXMpIHtcclxuICAgIG5ld0RhdGVzID0gY3VycmVudERhdGVzICsgJywnO1xyXG4gIH1cclxuICBuZXdEYXRlcyArPSBzZWxlY3RlZERhdGU7XHJcbiAgaGlkZGVuRGF0ZXNJbnB1dC52YWx1ZSA9IG5ld0RhdGVzO1xyXG5cclxuICAvLyBEaXNwbGF5IHRoZSBzZWxlY3RlZCBkYXRlIGluIHRoZSBjb250YWluZXIgKG9wdGlvbmFsKVxyXG4gIGNvbnN0IGRhdGVMYWJlbCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NwYW4nKTtcclxuICBkYXRlTGFiZWwudGV4dENvbnRlbnQgPSBzZWxlY3RlZERhdGU7XHJcbiAgZXhjbHVkZWREYXRlc0NvbnRhaW5lci5hcHBlbmRDaGlsZChkYXRlTGFiZWwpO1xyXG5cclxuICAvLyBDbGVhciB0aGUgZGF0ZSBpbnB1dCBmb3IgdGhlIG5leHQgc2VsZWN0aW9uXHJcbiAgZXhjbHVkZWREYXRlSW5wdXQudmFsdWUgPSAnJztcclxufTtcclxuXHJcbmFkZERhdGVCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBhZGREYXRlKTtcclxuXHJcblxyXG5cclxuLy8gY29uc3QgZm9ybSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdleGNsdWRlZC1kYXRlcy1mb3JtJyk7XHJcblxyXG4vLyBmb3JtLmFkZEV2ZW50TGlzdGVuZXIoJ3N1Ym1pdCcsIGFzeW5jIChldmVudCkgPT4ge1xyXG4vLyAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG4vLyAgIGNvbnN0IG5hbWUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbmFtZScpLnZhbHVlO1xyXG4vLyAgIGNvbnN0IGVtYWlsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2VtYWlsJykudmFsdWU7XHJcbi8vICAgY29uc3QgZGF0ZXMgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZGF0ZXMnKS52YWx1ZTtcclxuXHJcbi8vICAgY29uc3QgcmVzcG9uc2UgPSBhd2FpdCBmZXRjaChgJHt5b3VyX3dlYnNpdGVfdXJsfS93cC1qc29uL2Jjcy92MS9wcm9jZXNzLWJjcy1hZGQtZXhjbHVkZWQtZGF0ZXNgLCB7XHJcbi8vICAgICBtZXRob2Q6ICdQT1NUJyxcclxuLy8gICAgIGhlYWRlcnM6IHtcclxuLy8gICAgICAgJ0NvbnRlbnQtVHlwZSc6ICdhcHBsaWNhdGlvbi9qc29uJ1xyXG4vLyAgICAgfSxcclxuLy8gICAgIGJvZHk6IEpTT04uc3RyaW5naWZ5KHtcclxuLy8gICAgICAgbmFtZSxcclxuLy8gICAgICAgZW1haWwsXHJcbi8vICAgICAgIGRhdGVzXHJcbi8vICAgICB9KVxyXG4vLyAgIH0pO1xyXG5cclxuLy8gICBpZiAoIXJlc3BvbnNlLm9rKSB7XHJcbi8vICAgICBjb25zb2xlLmVycm9yKGBFcnJvcjogJHtyZXNwb25zZS5zdGF0dXN9YCk7XHJcbi8vICAgICBhbGVydCgnRXJyb3IgYWRkaW5nIGRhdGVzIScpO1xyXG4vLyAgICAgcmV0dXJuO1xyXG4vLyAgIH1cclxuXHJcbi8vICAgY29uc3QgZGF0YSA9IGF3YWl0IHJlc3BvbnNlLmpzb24oKTtcclxuLy8gICBhbGVydChkYXRhLm1lc3NhZ2UpO1xyXG4vLyB9KTtcclxuIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsInJlYWR5Iiwib24iLCJlIiwicHJldmVudERlZmF1bHQiLCJmb3JtRGF0YSIsIkZvcm1EYXRhIiwibmFtZSIsInZhbCIsImVtYWlsIiwiZGF0ZXMiLCJjb25zb2xlIiwibG9nIiwiZXJyb3IiLCJmZXRjaCIsIm1ldGhvZCIsImJvZHkiLCJKU09OIiwic3RyaW5naWZ5IiwidGhlbiIsInJlc3BvbnNlIiwianNvbiIsImRhdGEiLCJzdWNjZXNzIiwibWVzc2FnZSIsImNhdGNoIiwialF1ZXJ5IiwiZXhjbHVkZWREYXRlc0NvbnRhaW5lciIsImdldEVsZW1lbnRCeUlkIiwiaGlkZGVuRGF0ZXNJbnB1dCIsImV4Y2x1ZGVkRGF0ZUlucHV0IiwiYWRkRGF0ZUJ1dHRvbiIsImFkZERhdGUiLCJzZWxlY3RlZERhdGUiLCJ2YWx1ZSIsImN1cnJlbnREYXRlcyIsIm5ld0RhdGVzIiwiZGF0ZUxhYmVsIiwiY3JlYXRlRWxlbWVudCIsInRleHRDb250ZW50IiwiYXBwZW5kQ2hpbGQiLCJhZGRFdmVudExpc3RlbmVyIl0sInNvdXJjZVJvb3QiOiIifQ==