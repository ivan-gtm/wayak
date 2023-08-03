<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Sliders and Slider Items</title>
  <style>
    .sliderItems {
      display: none;
    }

    .activeSlider .sliderItems {
      display: block;
    }

    .sliderItems li {
      margin-bottom: 10px;
    }

    .sliderItems input {
      width: 40px;
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <h2>Sliders</h2>
  <ul id="slidersList"></ul>
  <div id="sliderItemsContainer" style="display: none;">
    <h2 id="sliderTitle"></h2>
    <ul id="sliderItemsList"></ul>
    <button id="backButton">Back</button>
  </div>

  <script>
        // Sample JSON data
    const slidersData = {!! $carousels !!};

    const slidersList = document.getElementById("slidersList");
    const sliderItemsContainer = document.getElementById("sliderItemsContainer");
    const sliderTitleElement = document.getElementById("sliderTitle");
    const sliderItemsList = document.getElementById("sliderItemsList");
    const backButton = document.getElementById("backButton");

    let currentSliderIndex = -1;
    let changesMade = false;

    // Function to render the sliders
    function renderSliders() {
      slidersList.innerHTML = '';

      slidersData.forEach((slider, sliderIndex) => {
        const sliderElement = document.createElement("li");
        const sliderTitleElement = document.createElement("h3");
        const sliderPositionInput = document.createElement("input");

        sliderTitleElement.textContent = slider.title;
        sliderPositionInput.type = "number";
        sliderPositionInput.value = sliderIndex + 1; // Set the current position
        sliderPositionInput.addEventListener("change", () => moveSlider(sliderIndex, parseInt(sliderPositionInput.value, 10) - 1));

        sliderElement.appendChild(sliderTitleElement);
        sliderElement.appendChild(sliderPositionInput);

        // Add click event listener to show slider items
        sliderTitleElement.addEventListener("click", () => showSliderItems(sliderIndex));

        slidersList.appendChild(sliderElement);
      });
    }

    // Function to show slider items and reorder inputs
    function showSliderItems(sliderIndex) {
      currentSliderIndex = sliderIndex;
      const slider = slidersData[sliderIndex];
      const sliderItems = slider.items;

      sliderItemsList.innerHTML = '';
      sliderTitleElement.textContent = slider.title;

      // Hide the slider input text for ordering
      slidersList.style.display = "none";

      sliderItems.forEach((item, itemIndex) => {
        const itemElement = document.createElement("li");
        const itemTitleElement = document.createElement("span");
        const itemImageElement = document.createElement("img");
        const moveItemInput = document.createElement("input");

        itemTitleElement.textContent = item.title;
        itemImageElement.src = item.preview_image_url;
        moveItemInput.type = "number";
        moveItemInput.value = itemIndex + 1;
        moveItemInput.addEventListener("change", () => moveSliderItem(itemIndex, parseInt(moveItemInput.value, 10) - 1));

        itemElement.appendChild(itemTitleElement);
        itemElement.appendChild(itemImageElement);
        itemElement.appendChild(moveItemInput);

        sliderItemsList.appendChild(itemElement);
      });

      // Show the slider items container
      sliderItemsContainer.style.display = "block";
    }

    // Function to move slider items
    function moveSliderItem(itemIndex, newPosition) {
      const sliderItems = slidersData[currentSliderIndex].items;

      if (newPosition < 0 || newPosition >= sliderItems.length || newPosition === itemIndex) {
        // Invalid position or no change needed
        return;
      }

      sliderItems.splice(newPosition, 0, sliderItems.splice(itemIndex, 1)[0]);

      // Mark that changes have been made
      changesMade = true;

      // Send the updated JSON data via AJAX and re-render the slider items
      if (changesMade) {
        saveChanges();
        renderSliderItems();
      }
    }

    // Function to move sliders
    function moveSlider(sliderIndex, newPosition) {
	    console.log(" Function to move sliders");
      if (newPosition < 0 || newPosition >= slidersData.length || newPosition === sliderIndex) {
        // Invalid position or no change needed
        return;
      }

      slidersData.splice(newPosition, 0, slidersData.splice(sliderIndex, 1)[0]);

      // Mark that changes have been made
      changesMade = true;

      // Send the updated JSON data via AJAX and re-render the sliders
      if (changesMade) {
        saveChanges();
        renderSliders();
      }
    }

    // Function to go back to the list of sliders
    function goBackToList() {
      sliderItemsContainer.style.display = "none";
      slidersList.style.display = "block";

      // Restore the slider input text for ordering
      renderSliders();
    }

    // Function to save changes and send the updated JSON data via AJAX
    function saveChanges() {
      if (changesMade) {
        // // Send the entire JSON data via AJAX
        const jsonData = JSON.stringify(slidersData);

        // Simulate AJAX request
        console.log("Sending JSON data via AJAX:", jsonData);

        // Reset changesMade flag
        changesMade = false;
        
          // Convert the JSON data to a string
          // const jsonData = slidersData;
          const url = "http://localhost:8001/admin/us/carousels/home/update";

          // Create a new XMLHttpRequest object
          const xhr = new XMLHttpRequest();
          const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
          const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : null;

          // Configure the request
          xhr.open("POST", url, true); // Replace "your_api_endpoint_here" with your actual API endpoint
          xhr.setRequestHeader("Content-Type", "application/json");

          // Set the CSRF token as the value of the "X-CSRF-TOKEN" header
          if (csrfToken) {
              xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
          }
          
          // Set up the event listener to handle the response
          xhr.onload = function () {
              if (xhr.status >= 200 && xhr.status < 300) {
                  // Request was successful
                  const response = JSON.parse(xhr.responseText);
              console.log("Response:", response);
              } else {
                  // Request failed
                  console.error("Request failed with status:", xhr.status);
              }
          };

          // Set up the event listener to handle errors
          xhr.onerror = function () {
              console.error("Request error occurred.");
          };

          // Send the JSON data
          xhr.send(jsonData);
      
      }
    }

    // Function to re-render the slider items after changes
    function renderSliderItems() {
      const slider = slidersData[currentSliderIndex];
      const sliderItems = slider.items;

      sliderItemsList.innerHTML = '';

      sliderItems.forEach((item, itemIndex) => {
        const itemElement = document.createElement("li");
        const itemTitleElement = document.createElement("span");
        const itemImageElement = document.createElement("img");
        const moveItemInput = document.createElement("input");

        itemTitleElement.textContent = item.title;
        itemImageElement.src = item.preview_image_url;
        moveItemInput.type = "number";
        moveItemInput.value = itemIndex + 1;
        moveItemInput.addEventListener("change", () => moveSliderItem(itemIndex, parseInt(moveItemInput.value, 10) - 1));

        itemElement.appendChild(itemTitleElement);
        itemElement.appendChild(itemImageElement);
        itemElement.appendChild(moveItemInput);

        sliderItemsList.appendChild(itemElement);
      });
    }

    // Initial render
    renderSliders();

    // Event listener for the back button
    backButton.addEventListener("click", goBackToList);
  </script>
</body>
</html>
