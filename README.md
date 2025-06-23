# edTechApp

A simple EdTech project built with **Laravel 12** (backend), **Vue.js 3** (frontend), and **OpenAI** for AI-powered learning assistance.

## Features
- Admins/teachers can upload short lesson texts.
- Students can read lessons.
- Students can ask questions about lessons via a chat box.
- AI (OpenAI/ChatGPT) answers student questions about the lesson.
- Bonus: The AI recommends other lessons based on the question.
- Responsive design (mobile-friendly).

## Tech Stack
- **Backend:** Laravel 12 (PHP)
- **Frontend:** Vue.js 3 (with Vite)
- **AI:** OpenAI GPT-3.5/4 API
- **Node:** v22 required

## Setup Instructions

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js 22.x
- npm
- OpenAI API key ([get one here](https://platform.openai.com/account/api-keys))

### 1. Clone the repository
```sh
git clone <repo-url> edTechApp
cd edTechApp
```

### 2. Install PHP dependencies
```sh
composer install
```

### 3. Install Node dependencies
```sh
npm install
```

### 4. Copy and configure environment variables
```sh
cp .env.example .env
```
- Set your database connection (SQLite by default works out of the box)
- Add your OpenAI API key:
  ```env
  OPENAI_API_KEY=sk-...
  ```

### 5. Generate app key and run migrations
```sh
php artisan key:generate
php artisan migrate
```

### 6. Start the development servers
- **Backend:**
  ```sh
  php artisan serve
  ```
- **Frontend:**
  ```sh
  npm run dev
  ```

### 7. Access the app
- Visit [http://localhost:5173](http://localhost:5173) (Vite dev server)
- Register as a user. To create lessons, log in as an admin (see below).

## How the AI Works
- On each lesson page, students can ask questions about the lesson content.
- The backend sends the lesson text and question to OpenAI's API.
- The AI responds with an answer and recommends other lessons.

## Admin/Teacher Access
- By default, all authenticated users can create/edit lessons. For real-world use, add a role check in `LessonController`.

## AI Tool Used
- [cohere v2 API](https://docs.cohere.com/v2/cohere-documentation)

## Customization
- To use another AI provider (like HuggingFace), update the `ask` method in `LessonController.php`.

## License
MIT 