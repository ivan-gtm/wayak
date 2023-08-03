<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <script>
        // var url = '/admin/us/carousel/item/delete?slider_id=' + encodeURIComponent(slider.slider_id) + '&item_id=' + encodeURIComponent(item._id);
        // Usage: Call the function and pass in your JSON data
        var jsonData = {!! $carousels !!};

        
        function displaySlidersWithImages(sliders) {
            // Get the existing ul element or create a new one
            var ul = document.querySelector('ul') || document.createElement('ul');

            // Clear the existing content of the ul element
            ul.innerHTML = '';

            // Iterate over each slider
            sliders.forEach(function(slider) {
                // Create a container div for each slider
                var sliderContainer = document.createElement('div');

                // Create an <h1> element to display the slider title
                var sliderTitle = document.createElement('h1');
                sliderTitle.textContent = slider.title;

                // Create a button element to delete the entire slider
                var deleteSliderButton = document.createElement('button');
                deleteSliderButton.textContent = 'Delete Slider';
                deleteSliderButton.addEventListener('click', function() {
                    // Remove the entire slider from the sliders array
                    sliders = sliders.filter(function(s) {
                        return s.slider_id !== slider.slider_id;
                    });
                    
                    console.log( "DELETE SLIDER" );
                    console.log( sliders );
                    // Call the function to send the JSON data via Ajax
                    sendJsonData( sliders );
                    
                    // Update the UI by re-rendering the sliders
                    displaySlidersWithImages(sliders);
                });

                // Append the slider title and delete slider button to the container div
                sliderContainer.appendChild(sliderTitle);
                sliderContainer.appendChild(deleteSliderButton);

                // Append the container div to the unordered list
                ul.appendChild(sliderContainer);

                // Iterate over each item in the slider
                slider.items.forEach(function(item) {
                    // Create list item element
                    var li = document.createElement('li');

                    // Set the text content for the list item
                    li.textContent = 'Title: ' + item.title + ', Search Term: ' + item.search_term;

                    // Create an image element and set its src attribute
                    var img = document.createElement('img');
                    img.src = item.preview_image_url;

                    // Create a button element to delete the item
                    var deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete Item';
                    deleteButton.addEventListener('click', function() {
                        // Remove the item from the slider
                        slider.items = slider.items.filter(function(it) {
                            return it._id !== item._id;
                        });

                        console.log( "DELETE ITEM" );
                        console.log( sliders );
                        // Call the function to send the JSON data via Ajax
                        sendJsonData( sliders );

                        // Update the UI by re-rendering the sliders
                        displaySlidersWithImages(sliders);
                    });

                    // Append the image element and delete button to the list item
                    li.appendChild(img);
                    li.appendChild(deleteButton);

                    // Append the list item to the unordered list
                    ul.appendChild(li);
                });
            });

            // Append the updated unordered list to the body or any other desired element
            document.body.appendChild(ul);
        }

        function addToCarousel(carousels, slider_id, title, search_term, imageUrls) {
            // Find the carousel in the JSON data based on the slider_id
            var carousel = carousels.find(function(carousel) {
                return carousel.slider_id === slider_id;
            });

            // If the carousel doesn't exist, create it
            if (!carousel) {
                carousel = {
                    slider_id: slider_id,
                    title: '', // Set the title of the new carousel
                    search_term: '', // Set the search_term of the new carousel
                    items: [],
                };
                carousels.push(carousel);
            }

            // Create a new item
            var newItem = {
                _id: generateItemId(), // You can implement a function to generate a unique item ID
                title: title,
                search_term: search_term,
                width: '', // You can set width and height as per your requirement
                height: '',
                forSubscribers: false,
                previewImageUrls: imageUrls,
                preview_image_url: imageUrls.carousel, // Assuming carousel URL is used as preview image URL
            };

            // Add the new item to the carousel
            carousel.items.push(newItem);

            return carousels; // Return the updated JSON data
        }

        // Helper function to generate a unique item ID
        function generateItemId() {
            // Implement your logic to generate a unique item ID (e.g., using Date.now() or uuid library)
            // For this example, I'm returning a random string as a simple unique ID.
            return Math.random().toString(36).substr(2, 9);
        }

        function addElement() {
            var sliderId = "k9Qvi";
            var newTitle = "New Item Title";
            var newSearchTerm = "new item";
            var imageUrls = {
                carousel: "new_item_carousel.jpg",
                large: "new_item_large.jpg",
                product_preview: "new_item_product_preview.jpg",
                thumbnail: "new_item_thumbnail.jpg",
            };

            var updatedJsonData = addToCarousel(jsonData, sliderId, newTitle, newSearchTerm, imageUrls);
            // displaySlidersWithImages(updatedJsonData);
            console.log(updatedJsonData);
            console.log("End");

            // ADD NEW SLIDER 
            var sliderId = "newSlider";
            var newTitle = "New Slider Title";
            var newSearchTerm = "new slider term";

            var updatedJsonData = addNewSlider(jsonData, sliderId, newTitle, newSearchTerm);
            console.log(updatedJsonData);

            var updatedJsonData = addToCarousel(jsonData, sliderId, newTitle, newSearchTerm, imageUrls);

            displaySlidersWithImages(updatedJsonData);
        }

        function addNewSlider(carousels, slider_id, title, search_term) {
            // Check if the slider_id already exists
            var existingSlider = carousels.find(function(slider) {
                return slider.slider_id === slider_id;
            });

            if (existingSlider) {
                console.log("Slider with slider_id '" + slider_id + "' already exists.");
                return carousels; // Return the unmodified JSON data
            }

            // Create a new slider object
            var newSlider = {
                slider_id: slider_id,
                title: title,
                search_term: search_term,
                items: [],
            };

            // Add the new slider to the carousels
            carousels.push(newSlider);

            return carousels; // Return the updated JSON data
        }

        function sendJsonData(data) {
            // Convert the JSON data to a string
            const jsonData = JSON.stringify(data);
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

        document.addEventListener("DOMContentLoaded", function(event) {
            console.log( jsonData );
            displaySlidersWithImages(jsonData);
            console.log("Helllo");
        });
    </script>
</body>

</html>