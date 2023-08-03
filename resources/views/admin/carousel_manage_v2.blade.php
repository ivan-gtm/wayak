<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Sliders and Slider Items</title>
</head>
<body>
  <h2>Sliders</h2>
  <ul id="slidersList"></ul>

  <script>
        // Sample JSON data
    const slidersData = {!! $carousels !!};

     // Function to render the sliders and slider items
     function renderSliders(sliders) {
      const slidersList = document.getElementById("slidersList");
      slidersList.innerHTML = '';

      sliders.forEach((slider, sliderIndex) => {
        const sliderElement = document.createElement("li");
        const sliderTitleElement = document.createElement("h3");
        const sliderItemsElement = document.createElement("ul");

        sliderTitleElement.textContent = slider.title;

        slider.items.forEach((item, itemIndex) => {
          const itemElement = document.createElement("li");
          const itemTitleElement = document.createElement("span");
          const itemImageElement = document.createElement("img");
          const moveItemUpButton = document.createElement("button");
          const moveItemDownButton = document.createElement("button");

          itemTitleElement.textContent = item.title;
          itemImageElement.src = item.preview_image_url;

          moveItemUpButton.textContent = "Move Up";
          moveItemUpButton.addEventListener("click", () => moveItem(sliderIndex, itemIndex, true));

          moveItemDownButton.textContent = "Move Down";
          moveItemDownButton.addEventListener("click", () => moveItem(sliderIndex, itemIndex, false));

          itemElement.appendChild(itemTitleElement);
          itemElement.appendChild(itemImageElement);
          itemElement.appendChild(moveItemUpButton);
          itemElement.appendChild(moveItemDownButton);

          sliderItemsElement.appendChild(itemElement);
        });

        const moveSliderUpButton = document.createElement("button");
        moveSliderUpButton.textContent = "Move Up";
        moveSliderUpButton.addEventListener("click", () => moveSlider(sliderIndex, true));

        const moveSliderDownButton = document.createElement("button");
        moveSliderDownButton.textContent = "Move Down";
        moveSliderDownButton.addEventListener("click", () => moveSlider(sliderIndex, false));

        sliderElement.appendChild(moveSliderUpButton);
        sliderElement.appendChild(moveSliderDownButton);
        sliderElement.appendChild(sliderTitleElement);
        sliderElement.appendChild(sliderItemsElement);

        slidersList.appendChild(sliderElement);
      });
    }

    // Function to move entire sliders up or down
    function moveSlider(sliderIndex, moveUp) {
      if (moveUp && sliderIndex > 0) {
        moveElement(slidersData, sliderIndex, sliderIndex - 1);
      } else if (!moveUp && sliderIndex < slidersData.length - 1) {
        moveElement(slidersData, sliderIndex, sliderIndex + 1);
      }

      // Update the UI with the new order
      renderSliders(slidersData);

      // Send the updated JSON data to the server via Ajax request
      // Replace "your_api_endpoint_here" with your actual API endpoint
      const jsonData = JSON.stringify(slidersData);
      sendJsonData(jsonData); // Implement this function to send the JSON data via Ajax
    }

    // Function to move slider items up or down
    function moveItem(sliderIndex, itemIndex, moveUp) {
      const sliderItems = slidersData[sliderIndex].items;

      if (moveUp && itemIndex > 0) {
        moveElement(sliderItems, itemIndex, itemIndex - 1);
      } else if (!moveUp && itemIndex < sliderItems.length - 1) {
        moveElement(sliderItems, itemIndex, itemIndex + 1);
      }

      // Update the UI with the new order
      renderSliders(slidersData);

      // Send the updated JSON data to the server via Ajax request
      // Replace "your_api_endpoint_here" with your actual API endpoint
      const jsonData = JSON.stringify(slidersData);
      sendJsonData(jsonData); // Implement this function to send the JSON data via Ajax
    }

    // Function to move elements within an array
    function moveElement(array, currentIndex, newIndex) {
      if (newIndex >= array.length) {
        let k = newIndex - array.length + 1;
        while (k--) {
          array.push(undefined);
        }
      }
      array.splice(newIndex, 0, array.splice(currentIndex, 1)[0]);
    }

    function sendJsonData(data) {
            // Convert the JSON data to a string
            const jsonData = data;
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

    // Initial render
    renderSliders(slidersData);

  </script>
</body>
</html>
