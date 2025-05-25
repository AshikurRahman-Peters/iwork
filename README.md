# 🧵 Smart Count for Worker

**Smart Count for Worker** is a garment industry productivity tool designed to track real-time output, efficiency, and performance of workers on the production floor. This system helps supervisors and management gain insights into how many garments are being completed, per-worker productivity, line efficiency, and much more.

---

## 🚀 Features

- ✅ Real-time garment count per worker
- 📊 Efficiency tracking (based on SMV, Target, Actual Output)
- 👨‍🏭 Worker-wise and Line-wise performance summary
- 🧮 Automatic calculation of:
  - Total Output
  - Efficiency (%)
  - Standard Minutes (SMV)
  - Man-to-Machine Ratio
- 📅 Daily, Weekly, and Monthly Reports
- 📱 Mobile-friendly interface for floor-level data entry
- 🔐 Role-based access (Admin, Supervisor, Operator)

---

## 🎯 Use Case

1. 🧑‍🏭 **Worker scans** or enters their ID.
2. 🧵 **Garment unit** is recorded upon completion.
3. 📡 **Data is stored** and analyzed in real-time.
4. 📈 **Efficiency is calculated** against set targets.
5. 📃 **Reports generated** for production and HR review.

---

## 📸 Screenshots

_Coming soon_

---

## 🛠️ Tech Stack

- **Backend**: PHP / Laravel / MySQL
- **Frontend**: Bootstrap / Vue.js or React
- **APIs**: RESTful JSON APIs
- **Devices**: PC / Tablet / Mobile

---

## 📦 Installation

```bash
git clone https://github.com/YourUsername/smart-count.git
cd smart-count
# Setup your .env and database
composer install
php artisan migrate
php artisan serve
