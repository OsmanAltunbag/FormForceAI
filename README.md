FormForce AI 🤖

AI-powered form builder — describe a form in plain language, get a fully functional form instantly.

FormForce AI is a full-stack PHP/Laravel web application where users describe a form in natural language (e.g. "Create a job application form with name, email, experience level, and a cover letter") and Google Gemini AI generates the complete form schema in real time. Forms are instantly shareable via a unique public URL, and all submissions are collected and manageable through a personal dashboard.

Features

🧠 AI Form Generation — Describe your form in plain English; Gemini 2.0 Flash returns a structured JSON schema with typed fields
💬 Multi-turn Conversation — Refine and iterate on your form through a chat interface; the AI remembers context across the session
👁️ Live Form Preview — Form fields are rendered in real time on the right panel as the AI responds
🔗 Shareable Public Links — Every saved form gets a unique /f/{slug} URL accessible to anyone without login
📊 Submissions Dashboard — View, manage, and track all form responses in a personal dashboard
🔒 Authentication — Secure user registration, login, and logout via Laravel Breeze
⚡ Rate Limiting — AI endpoint is protected (10 requests/minute per user) to prevent abuse and stay within API quotas
🗑️ Soft Deletes — Forms are soft-deleted to keep data recoverable
✅ Dynamic Validation — Public form submissions are validated server-side against the form's own schema at runtime


AI Concepts Applied
This project was built to demonstrate practical, applied AI engineering — not just API calls.
ConceptImplementationPrompt EngineeringA carefully designed system prompt instructs Gemini to return only valid JSON in a strict schema — no markdown, no explanation, no deviationStructured JSON OutputThe model output is constrained to a typed field schema (text, email, select, radio, etc.) that is parsed and rendered directly into HTMLConversation Context ManagementThe full chat history is stored in the PHP session and injected into every subsequent API call, enabling multi-turn refinementRate Limiting & GuardrailsLaravel's rate limiter guards the AI endpoint; error handling catches malformed JSON and API failures gracefullyDynamic Validation from AI OutputThe form schema returned by the AI drives server-side validation rules at submission time — the AI's required flags become Laravel validation rules

How It Works
User types: "Create a contact form with name, email, and message"
        ↓
Laravel sends prompt + chat history → Gemini 2.0 Flash API
        ↓
Gemini returns structured JSON:
{
  "title": "Contact Form",
  "fields": [
    { "label": "Name",    "type": "text",     "name": "name",    "required": true },
    { "label": "Email",   "type": "email",    "name": "email",   "required": true },
    { "label": "Message", "type": "textarea", "name": "message", "required": true }
  ]
}
        ↓
Laravel parses JSON → renders live HTML preview
        ↓
User saves → form gets a unique slug → shareable at /f/{slug}
        ↓
Anyone fills the form → submission stored in MySQL → visible in dashboard

Supported Field Types
text · email · textarea · select · checkbox · radio · number · date

Project Structure
app/
├── Http/Controllers/
│   ├── FormBuilderController.php   # AI chat + form generation + save
│   ├── FormController.php          # Toggle active, soft delete
│   ├── DashboardController.php     # User dashboard with form list
│   ├── SubmissionController.php    # View responses per form
│   └── PublicFormController.php    # Public form page + submit handler
├── Models/
│   ├── Form.php                    # Form model (SoftDeletes, slug generation)
│   └── Submission.php              # Submission model (JSON cast)
└── Services/
    └── GeminiService.php           # Google Gemini API integration

resources/views/
├── builder/index.blade.php         # Two-panel: AI chat + live form preview
├── dashboard/index.blade.php       # Form management table
├── submissions/index.blade.php     # Dynamic submissions viewer
└── public/
    ├── form.blade.php              # Public-facing form (no auth required)
    └── thank-you.blade.php         # Post-submission confirmation

Local Setup
Requirements

PHP 8.2+
Composer
MySQL 8.0+
Node.js & npm
A free Google Gemini API Key

Installation
bash# 1. Clone the repository
git clone https://github.com/your-username/formforce.git
cd formforce

# 2. Install PHP dependencies
composer install

# 3. Install and build frontend assets
npm install && npm run build

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your database in .env
# DB_DATABASE=formforce_db
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# 7. Add your Gemini API key in .env
# GEMINI_API_KEY=your_gemini_api_key_here

# 8. Run migrations
php artisan migrate

# 9. Start the development server
php artisan serve
Visit http://localhost:8000 — register an account and start building forms.

Environment Variables
envAPP_NAME=FormForceAI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=formforce_db
DB_USERNAME=formforce_user
DB_PASSWORD=secret

GEMINI_API_KEY=your_gemini_api_key_here

Screenshots

(Add screenshots here)

Form Builder (AI Chat + Live Preview)DashboardPublic FormShow ImageShow ImageShow Image

Deployment (Railway)

Push to GitHub (ensure .env is in .gitignore)
Create a new project on Railway from the GitHub repo
Add a MySQL plugin and copy the connection variables
Set all environment variables in the Railway dashboard
Run migrations via the Railway shell: php artisan migrate --force


About This Project
FormForce AI was built as a personal project to explore applied AI engineering with PHP — specifically prompt engineering, structured AI output, and context-aware multi-turn conversations. It demonstrates how LLMs can be integrated into production-grade web applications as functional, constrained components rather than open-ended chat tools.

Built with PHP 8.2 · Laravel 11 · Google Gemini 2.0 Flash · MySQL · Tailwind CSS