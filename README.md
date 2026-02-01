## 📈 Dynamic Indicator Updater 📈

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://example.com/build)
[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/yourusername/yourrepository/blob/main/LICENSE)

## 🚀 Descripción

This PHP project automatically updates a database of key financial indicators (USD/COP, EUR/COP, BTC/USD, Gold/USD, Brent Crude/USD) 
using data from multiple APIs. It includes fallback mechanisms and error handling to ensure consistent updates even when API connections 
are temporarily unavailable.  This script is designed for simple integration and can be easily extended to monitor more currencies or assets.

---

## 🌟 Características

*   **Multi-API Support:**  Fetches data from ExchangeRate-API (for USD/COP and EUR/COP) and CoinGecko (for BTC/USD).
*   **Fallback Mechanisms:** Uses hardcoded values (e.g., 4000 for USD/COP) as fallbacks if API connections fail.
*   **Automatic Updates:**  Runs automatically (schedule this yourself – not included in the script).
*   **Error Handling:** Includes robust try-catch blocks and informative messages to diagnose and address issues.
*   **Database Integration:**  Stores indicator values in a database for easy access and reporting.  (See "Database" section below).
*   **Configurable API Key:**  Allows you to easily change your ExchangeRate-API key.
*   **Clear Logging:**  Provides detailed logging to the console for debugging and monitoring.

---

## 🛠️ Tecnologías Utilizadas

*   **PHP:** 8.1 or higher
*   **PDO:**  PHP Data Objects - for database interaction.
*   **JSON:**  For parsing API responses.
*   **`file_get_contents`:** For fetching data from URLs.
*   **`stream_context_create`:**  For managing HTTP requests (timeouts, headers).

---

## 🖼️ Vista previa

![Indicadores](previewindi.gif)

--- 

## 🚀 Demo
[Indicadores](https://jcduro.bexartideas.com/proyectos/dashjc/indicadores/indicadores.php)

---

## 📊 Lenguajes y Herramientas

[![My Skills](https://skillicons.dev/icons?i=html,css,js,php,mysql,github,vscode,windows,&theme=light&perline=8)](https://skillicons.dev)


---

![Screenshot of the PHP Script Output](placeholder_screenshot.png)  *(Replace `placeholder_screenshot.png` with an actual screenshot of the script's output)*

## ⚙️ Base de Datos (Database)

*   **Database:** MySQL / MariaDB (Recommended)
*   **Table Name:** `indicadores`
*   **Columns:**
    *   `codigo` (VARCHAR(20)):  Indicator code (e.g., 'USD_COP').  PRIMARY KEY
    *   `valor` (DECIMAL(10, 2)): Indicator value.
    *   `fecha` (DATE):  Date of the update.

    **Example SQL:**

    ```sql
    CREATE TABLE indicadores (
        codigo VARCHAR(20) PRIMARY KEY,
        valor DECIMAL(10, 2),
        fecha DATE
    );
    ```

## ⚙️ Configuración (Configuration)

1.  **Obtén una API Key:** You'll need a free API key from ExchangeRate-API ([https://www.exchangerate-api.com/](https://www.exchangerate-api.com/)).  You'll also need a CoinGecko API key ([https://pro.coingecko.com/api/documentation](https://pro.coingecko.com/api/documentation)).
2.  **Reemplaza `TU_KEY_AQUI`:** In the PHP code, replace the placeholder `'TU_KEY_AQUI'` with your actual API key.  Make sure to save the file.
3.  **Database Credentials:**  Configure your database connection details (host, username, password, database name) in the PHP code.

## 🚀 Cómo Ejecutar (How to Run)

1.  **Save the code:** Save the provided PHP code as a `.php` file (e.g., `indicator_updater.php`).
2.  **Set up your database:** Create the `indicadores` table in your MySQL database.
3.  **Update the configuration:**  Replace `TU_KEY_AQUI` with your API key.
4.  **Execute the script:**  Run the PHP script from your terminal using `php indicator_updater.php`.
5.  **Schedule the script:** Use a task scheduler (like cron) to automatically run the script on a regular basis.

## 💡 Contribuciones (Contributions)

We welcome contributions to this project!  If you have any ideas, bug reports, or pull requests, please submit them through GitHub.

## 🙏 Licencia (License)

This project is licensed under the MIT License - see the [LICENSE](https://github.com/yourusername/yourrepository/blob/main/LICENSE) file for details.

---

**Important Notes:**

*   **Replace Placeholders:** Fill in the bracketed placeholders with accurate information.
*   **API Keys:**  Never commit your API keys directly to your repository.  Use environment variables or a configuration file to store them securely.
*   **Scheduling:** The script doesn't include scheduling.  You'll need to set up a task scheduler (cron on Linux/macOS, Task Scheduler on Windows) to run it automatically.
*   **Error Logging:**  Consider adding more detailed error logging to a file for easier troubleshooting.
*   **Security:**  This is a simple example.  For production environments, you'll need to implement additional security measures (e.g., input validation, output escaping, database security).

To create the placeholder screenshot, simply save the above markdown to a file named `README.md` in your repository.

I've used Markdown formatting to create a nicely formatted README. Remember to replace the placeholders with your specific details and update the link to your GitHub repository.  Good luck!
