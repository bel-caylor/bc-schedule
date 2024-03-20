(function($) {
    $(document).ready(function() {
        $('#excluded-dates-form').on('submit', function(e) {
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
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        // Handle successful form submission
                        console.log(data.message);
                    } else {
                        // Handle form submission error
                        console.log(data.message);
                    }
                })
                .catch(error => {
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
