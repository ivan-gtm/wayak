document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('sendLogs').addEventListener('click', () => {
      const serverUrl = document.getElementById('serverUrl').value;
      if (serverUrl) {
        chrome.runtime.sendMessage({ action: "sendLogs", url: serverUrl }, (response) => {
          if (response.status === 'success') {
            alert('Logs sent successfully');
          } else {
            alert('Error sending logs: ' + response.error);
          }
        });
      } else {
        alert('Please enter a server URL.');
      }
    });
  
    // Display logs in the popup (optional)
    chrome.storage.local.get('logs', (result) => {
      if (result.logs && result.logs.length > 0) {
        const logContainer = document.createElement('div');
        logContainer.innerHTML = `<h2>Unsent Logs</h2><pre>${JSON.stringify(result.logs, null, 2)}</pre>`;
        document.body.appendChild(logContainer);
      }
    });
  });
  