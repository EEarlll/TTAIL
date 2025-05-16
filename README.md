# Attendance System with DTR Logging and SMS Notifications

## Project Overview
This project involves the development of an advanced attendance system using PHP and MySQL, enhanced with GSM module integration for SMS notifications. The primary features include QR code-based attendance recording and automated SMS alerts to ensure efficient and reliable attendance tracking. The system has been successfully implemented in two educational institutions: The Thomas Aquinas Institute of Learning and Southwoods School of Cavite.

## Features
1. **QR Code-Based Attendance Recording**
   - **Efficient Scanning:** Students can quickly mark their attendance by scanning a unique QR code.
   - **Real-Time Logging:** Attendance data is instantly recorded in the database upon scanning.
2. **SMS Notifications**
   - **Automated Alerts:** Parents or guardians receive SMS notifications about their child's attendance status.
   - **GSM Module Integration:** A GSM module is used to send SMS alerts, ensuring timely and reliable communication.
3. **DTR (Daily Time Record) Logging**
   - **Comprehensive Tracking:** The system logs detailed attendance data, including timestamps for arrivals and departures.
   - **Report Generation:** Administrators can generate and review attendance reports for individual students or the entire class.
4. **Balance Transaction via QR Code**
      - **Cashless Payments:** Students and staff can perform balance transactions (such as adding funds or making payments) by scanning their QR codes.
      - **Secure Processing:** Each transaction is securely logged and linked to the individual's account for transparency and accountability.
      - **Instant Updates:** Account balances are updated in real-time, and users receive confirmation of successful transactions.

## Technical Implementation
### Technologies Used
- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **QR Code Generation and Scanning:** Libraries and tools for creating and reading QR codes
- **SMS Notifications:** GSM module for sending SMS alerts

### System Architecture
- **User Interface:** Students scan their QR codes using a web-based interface or a dedicated scanning device.
- **Backend Processing:** The scanned QR code is sent to the server, where PHP scripts handle the data processing.
- **Database Management:** MySQL stores all attendance records, which can be accessed and managed by administrators.
- **SMS Notification:** The GSM module sends SMS notifications to parents or guardians based on the attendance data.

## Implementation Sites
- **The Thomas Aquinas Institute of Learning:** The system has been deployed to enhance the attendance monitoring process and improve communication with parents.
- **Southwoods School of Cavite:** Similar implementation has been carried out to streamline attendance recording and provide real-time updates to parents.

## Installation and Setup
1. **Server Setup:** Ensure that a web server with PHP and MySQL support is available.
2. **Database Configuration:** Import the provided SQL file to set up the necessary database tables.
3. **QR Code Setup:** Generate unique QR codes for each student and distribute them accordingly.
4. **GSM Module Configuration:** Connect and configure the GSM module to enable SMS notifications.
5. **System Deployment:** Upload the project files to the server and configure the system settings as per the requirements.

## Usage Instructions
- **Scanning QR Codes:** Students scan their QR codes upon arrival and departure.
- **Monitoring Attendance:** Administrators can monitor and manage attendance records through the admin panel.
- **Receiving Notifications:** Parents or guardians receive SMS notifications based on the attendance data.

## Live Usage
Here's a sneak peek of our application in action:
<div style="display:flex; flex-direction:row">
   <img src="storage/Screenshot%202024-06-01%20224743.png" height="250rm">
<img src="storage/Screenshot%202024-06-01%20225427.png" height="250rm">
<img src="storage/Screenshot%202024-06-01%20225530.png" height="250rm">
</div>

## Contact
If you have any questions or feedback, you can reach out to me at `earleustacio@gmail.com`.
