$(document).ready(function() {    
    $("#bgscale").slider({
        formatter: function(value) {
            return value + "%"
        }
    });
    
    attachKeypressHandlerToBgSearch();
    
});

function attachKeypressHandlerToBgSearch() {
    $("#bgsearch").on("keypress", function(e) {
        logDebug('Keypress event on "#bgsearch"');
        if (isEnterKeyPressed(e)) {
            handleEnterKeyPressOnBgSearch($(this).val());
        }
    });
}

function logDebug(message) {
    if (DEBUG) {
        console.log(message);
    }
}

function isEnterKeyPressed(event) {
    return event.which === 13;
}

function handleEnterKeyPressOnBgSearch(searchValue) {
    var processedValue = processSearchValue(searchValue);
    if (processedValue) {
        initMasonry_bg();
        loadTemplates_bg();
    }
}

function processSearchValue(value) {
    // Assuming the original intent was to ensure there is a word character in the value
    var matches = value.match(/\w+/g);
    return matches ? matches.toString() : null;
}
