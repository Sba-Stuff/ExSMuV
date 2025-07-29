# ExSMuV-Exploration-Software-for-Summarized-Multimedia-Vertical-Search-Results

# ExSMuV Setup Guide
<img width="440" height="145" alt="ExSMuV" src="https://github.com/user-attachments/assets/b4e9c4e7-4f38-4011-a54e-c96d13a69317" />


[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://github.com/yourusername/ExSMuV)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Last Updated](https://img.shields.io/badge/last%20updated-July%202025-orange)](https://github.com/yourusername/ExSMuV)

> A step-by-step setup guide for running the ExSMuV software on a Windows PC.

---

## Requirements

- 64-bit **Windows Operating System**
- **Chromedriver**
- **Standalone Chrome** (Selinium Automation Version)
- **Server Software** (WAMP, XAMPP, UniServer, etc.) with curl and zlib library enabled.

---

## Folder Structure

Create the following folder and subfolders anywhere on your PC:

```
ExSMuV/
├── chromedriver/
├── chrome/
└── server/
```

---

## Setup Instructions

1. **Download Chromedriver**  
   Extract it into the `chromedriver/` folder.

2. **Download Chrome (Standalone)**  
   Extract it into the `chrome/` folder.  
   > If Chrome is already running, **exit it from the system tray** to avoid conflicts.

3. **Download a Local Server**  
   Use **WAMP**, **XAMPP**, **UniServer**, or similar and extract into the `server/` folder.  
   > This guide uses **UniServer** as an example.

4. **Enable `curl` Library**  
   Make sure the `curl` extension is turned **on** in your server's PHP configuration.

5. **Start Chromedriver**  
   - Open the `chromedriver/` folder.
   - Type `cmd` in the address bar and press Enter.
   - Run the following command:

     ```bash
     chromedriver.exe --port=49400
     ```

   - When it says "Running", **minimize** the window (do not close it).

6. **Run Chrome**  
   Open `chrome/Chrome.exe`.

7. **Download ExSMuV Code**  
   - Clone or download the GitHub repository.
   - Extract the contents into your server's `htdocs/` or `www/` directory.

8. **Launch the Server**  
   Start the preferred server (e.g., `UniServerZ.exe`).

9. **Open Browser**  
   Navigate to:

   ```
   http://localhost
   ```

   You should see the **ExSMuV interface**.

10. **Test Example Queries**  
    Try the sample queries:  
    - `"Chemistry"`
    - `"Harry Potter"`  
    These are **cached** for demonstration purposes.

---

## When Done

- Close the **Chrome browser**
- Close the **Command Prompt** running `chromedriver`
- Shut down the **Server**

---

## Notes

- You can change the server, Chrome, or chromedriver versions based on compatibility.
- If you face any issue, try re-running from Step 5.

---

## 📄 License

MIT
