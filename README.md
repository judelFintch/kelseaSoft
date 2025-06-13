# KelseaSoft - Customs Agency Management Software

## Overview
KelseaSoft is a powerful and intuitive **customs agency management software** developed using **Laravel 12 and Livewire 3**. It enables customs agencies to efficiently manage **truck and cargo registrations, document attachments, invoicing, and payment tracking**. The system provides a seamless experience for handling client records, generating invoices, and ensuring a streamlined workflow.

## Features
### 🚛 Truck & Cargo Registration
- Register truck details (truck number, weight, container number, etc.).
- Enter cargo information (FOB, insurance, CIF auto-calculation).

### 📂 Dossier Management
- List and manage all registered dossiers.
- Perform operations like update, delete, and validate dossiers.
- Attach scanned documents such as **invoices, bills of lading (BL), receipts, and other proofs**.
- View dossiers with their attached documents in an intuitive way.

### 🧾 Invoicing System
- Link invoices to dossiers with the ability to **input liquidation elements, fees, and expenses**.
- Generate invoices in **PDF format** with the header of each company.
- Invoice numbers use two different formats:
  - For **regular invoices**: `MDB<ACRONYM>NNyy` (year only).
  - For **global invoices**: `MDB<ACRONYM>GLNNmmyy` (includes month and year).
- Sequential numbering begins at **335** for invoices and **057** for global invoices.
- Track payment status (**Paid, Pending, Partially Paid**).

### 🏢 Client Management
- Pre-register **client companies** with relevant details (name, address, contact, company type).
- Assign dossiers to registered companies or enter a custom client name (stored in the `client` field).
- Access client dossier history.

### 📜 Document Handling
- Upload and manage scanned documents.
- Preview attached files directly within the system.

## Technology Stack
- **Backend**: Laravel 12
- **Frontend**: Livewire 3
- **Database**: MySQL / PostgreSQL
- **Storage**: Local filesystem / Cloud storage (AWS S3, Google Drive)
- **PDF Generation**: DomPDF / Laravel Snappy

## Installation
### Requirements
- PHP 8.1+
- Composer
- Node.js & npm
- MySQL / PostgreSQL database

### Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/kelseasoft.git
   cd kelseasoft
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install && npm run dev
   ```
3. Set up the environment file:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure database in `.env` and run migrations:
   ```sh
   php artisan migrate --seed
   ```
5. Start the application:
   ```sh
   php artisan serve
   ```

## Usage
- **Login**: Access the system using your credentials. User registration is
  restricted to authenticated accounts.
- **Dossier Management**: Create and manage dossiers efficiently.
- **Attach Documents**: Upload supporting files for each dossier.
- **Generate Invoices**: Process invoices and export them as PDFs.
- **Track Payments**: Monitor payment statuses of each invoice.

## Contributing
We welcome contributions to enhance KelseaSoft. Feel free to submit pull requests or report issues.

## License
KelseaSoft is released under the MIT License.
