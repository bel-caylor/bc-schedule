<form id="excluded-dates-form">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required>
  <br>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>
  <br>

  <fieldset id="excludedDatesSubform">
    <label for="excludedDate">Excluded Date:</label>
    <input type="date" id="excludedDate">
    <button type="button" id="addDateButton">Add Date</button>
  </fieldset>

  <label for="dates">Excluded Dates (comma separated):</label>
  <div id="excludedDates"></div>  <input type="hidden" id="dates" name="dates" required>
  <br>
  <button type="submit">Submit</button>
</form>