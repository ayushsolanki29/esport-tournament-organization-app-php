const searchInput = document.getElementById("searchInput");
const autocompleteSuggestions = document.getElementById("autocompleteSuggestions");

searchInput.addEventListener("input", function () {
    // Show/hide autocomplete suggestions based on input value
    if (searchInput.value.trim() === "") {
        autocompleteSuggestions.style.display = "none";
    } else {
        autocompleteSuggestions.style.display = "block";
    }
});

// Event listener for when user clicks outside the input and suggestions container
document.addEventListener("click", function (event) {
    if (!searchInput.contains(event.target) && !autocompleteSuggestions.contains(event.target)) {
        autocompleteSuggestions.style.display = "none";
    }
});

function getSuggestions() {
    // Get the value from the txt_id field
    
  
    // Send an AJAX request to a PHP script to fetch autocomplete suggestions
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/functions.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Display the autocomplete suggestions
            document.getElementById("team_data").innerHTML = xhr.responseText;
        }
    };
    xhr.send("team_name=" + searchInput.value);
  }