let logs = [];

// Load logs from localStorage when the extension is started
chrome.runtime.onStartup.addListener(() => {
  chrome.storage.local.get('logs', (result) => {
    if (result.logs) {
      logs = result.logs;
    }
  });
});

// Listen for completed image requests and log them
chrome.webRequest.onCompleted.addListener(
  function(details) {
    if (details.type === 'image') {
      const logEntry = {
        url: details.url,
        timestamp: Math.floor(Date.now() / 1000)
      };
      logs.push(logEntry);
      chrome.storage.local.set({ logs: logs });
    }
  },
  { urls: ["<all_urls>"] }
);

// Handle messages from the popup
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
  if (request.action === "sendLogs") {
    // Send logs to the specified server URL
    fetch(request.url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(logs)
    })
    .then(response => response.json())
    .then(data => {
      // Clear logs if sending was successful
      logs = [];
      chrome.storage.local.set({ logs: logs });
      sendResponse({ status: 'success', data: data });
    })
    .catch(error => {
      sendResponse({ status: 'error', error: error });
    });
    return true;  // Keeps the message channel open for sendResponse
  }
});
