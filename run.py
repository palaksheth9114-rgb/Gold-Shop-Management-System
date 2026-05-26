import os
import time
import webbrowser

try:
    import webview  # pywebview
except ImportError:
    webview = None

def start_server():
    # Start Apache & MySQL from XAMPP (Windows)
    xampp_start = r"C:\xampp\xampp_start.exe"
    if os.path.exists(xampp_start):
        os.system(xampp_start)

def stop_server():
    # Optional: Stop Apache & MySQL
    xampp_stop = r"C:\xampp\xampp_stop.exe"
    if os.path.exists(xampp_stop):
        os.system(xampp_stop)

class Api:
    def open_browser(self, url):
        """Open URL in system default browser"""
        # If URL already starts with http:// or https://, use it directly
        if url.startswith('http://') or url.startswith('https://'):
            full_url = url
        # Convert relative URL to absolute if needed
        elif url.startswith('invoice.php') or url.startswith('/invoice.php'):
            full_url = f"http://localhost/NUTAN/{url.lstrip('/')}"
        elif not url.startswith('http'):
            full_url = f"http://localhost/NUTAN/{url}"
        else:
            full_url = url
        # Open in system default browser
        webbrowser.open(full_url)
        return {'status': 'opened'}

def open_site():
    url = "http://localhost/NUTAN/index.php"
    time.sleep(5)  # wait for server to start
    if webview is None:
        raise RuntimeError("pywebview is not installed. Install with: pip install pywebview")
    
    api = Api()
    window = webview.create_window(
        "Gold Management System", 
        url, 
        width=1200, 
        height=800, 
        resizable=True,
        js_api=api
    )
    webview.start(gui="tk", debug=False)

if __name__ == "__main__":
    start_server()
    open_site()

    # If you want the server to stop automatically when you close the app:
    # input("Press Enter to stop server...")
    # stop_server()
