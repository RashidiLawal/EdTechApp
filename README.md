# edTechApp

A modern EdTech learning platform built with **Laravel 12** (backend), **Vue.js 3** (frontend), and **Cohere AI** for intelligent learning assistance.

## 🚀 Features

### **For Teachers/Admins:**
- 📝 **Lesson Management:** Create, edit, and delete educational content
- 🎯 **Role-based Access:** Secure admin/teacher controls
- 📊 **Content Organization:** Easy lesson management interface

### **For Students:**
- 📖 **Lesson Reading:** Clean, responsive lesson viewing
- 🤖 **AI-Powered Q&A:** Ask questions about lessons and get intelligent answers
- 🎯 **Smart Recommendations:** AI suggests related lessons based on questions
- 📱 **Mobile-Friendly:** Responsive design works on all devices

### **AI Integration:**
- 🧠 **Cohere AI:** Powered by advanced language models for intelligent responses
- 💬 **Interactive Chat:** Real-time Q&A with lesson context
- 🔗 **Smart Recommendations:** AI suggests related lessons

## 🛠 Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Vue.js 3 + Inertia.js + Vite
- **AI:** Cohere API (text generation & Q&A)
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Styling:** Tailwind CSS
- **Node.js:** v22+ required

## 📋 Prerequisites

- PHP >= 8.2
- Composer
- Node.js 22.x
- npm
- Cohere API key ([get one here](https://dashboard.cohere.com/api-keys))

## 🚀 Quick Setup

### 1. **Clone & Install**
```bash
git clone <repo-url> edTechApp
cd edTechApp
composer install
npm install
```

### 2. **Environment Setup**
```bash
cp .env.example .env
```

Add your Cohere API key to `.env`:
```env
COHERE_API_KEY=your_cohere_api_key_here
```

### 3. **Database & Keys**
```bash
php artisan key:generate
php artisan migrate
```

### 4. **Create Admin User**
```bash
# First register a user through the web interface
# Then make them admin:
php artisan user:make-admin your-email@example.com
```

### 5. **Start Development Servers**
```bash
# Terminal 1 - Backend
php artisan serve

# Terminal 2 - Frontend (if crypto error, see troubleshooting below)
npm run dev

# A single Terminal - Frontend and Backend (if crypto error, see troubleshooting below)
composer run dev
```

### 6. **Access Your App**
- **Main App:** http://localhost:5173
- **Backend API:** http://127.0.0.1:8000

## 🔧 Troubleshooting

### **Crypto Error (Node.js)**
If you get `crypto.getRandomValues is not a function`:
```bash
# Try clearing node modules and reinstalling
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### **Permission Issues**
If you can't access lesson creation:
```bash
# Make sure your user is an admin
php artisan user:make-admin your-email@example.com
```

## 📱 How to Use

### **For Teachers/Admins:**
1. **Login** with your admin account
2. **Create Lessons:** Go to `/lessons/create`
3. **Manage Content:** Edit/delete lessons from `/lessons`
4. **Monitor Usage:** Check student engagement

### **For Students:**
1. **Browse Lessons:** Visit `/lessons`
2. **Read Content:** Click on any lesson
3. **Ask Questions:** Use the AI chat box on lesson pages
4. **Get Recommendations:** AI suggests related lessons

## 🧠 How the AI Works

### **Q&A Process:**
1. Student asks a question about a lesson
2. Backend sends lesson content + question to Cohere AI
3. AI generates contextual answer based on lesson material
4. System recommends related lessons
5. Results displayed to student

### **AI Features:**
- **Context-Aware:** AI understands lesson content
- **Smart Recommendations:** Suggests related lessons
- **Real-time Responses:** Instant answers
- **Educational Focus:** Tailored for learning

## 🔐 Security & Roles

### **Role System:**
- **Student:** Can read lessons and use AI chat
- **Teacher:** Can create/edit lessons + student features
- **Admin:** Full access to all features

### **Access Control:**
- Middleware protects admin routes
- Role-based UI elements
- Secure API endpoints

## 🎨 UI/UX Features

### **Modern Design:**
- **Responsive Layout:** Works on mobile, tablet, desktop
- **Clean Interface:** Professional, educational design
- **Breadcrumb Navigation:** Easy page navigation
- **Loading States:** Smooth user experience
- **Error Handling:** Clear feedback messages

### **Interactive Elements:**
- **Real-time Chat:** AI Q&A interface
- **Dynamic Content:** Role-based UI changes
- **Smooth Transitions:** Professional animations

## 🔧 Customization

### **AI Provider:**
To use a different AI provider, update `LessonController.php`:
```php
// Replace Cohere with your preferred provider
$response = $client->post('your-ai-endpoint', [
    'json' => ['your-parameters']
]);
```

### **Styling:**
- Modify Tailwind classes in Vue components
- Update color scheme in `tailwind.config.js`
- Customize layouts in component files

## 📊 Database Schema

### **Users Table:**
- `id`, `name`, `email`, `password`
- `role` (student/teacher/admin)
- `email_verified_at`, `created_at`, `updated_at`

### **Lessons Table:**
- `id`, `title`, `content`
- `created_at`, `updated_at`

## 🚀 Deployment

### **Production Setup:**
1. Set `APP_ENV=production` in `.env`
2. Run `npm run build` for production assets
3. Configure your web server (Apache/Nginx)
4. Set up SSL certificates
5. Configure database for production

### **Environment Variables:**
```env
APP_ENV=production
APP_DEBUG=false
COHERE_API_KEY=your_production_key
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

MIT License - see LICENSE file for details

## 🆘 Support

- **Issues:** Create a GitHub issue
- **Documentation:** Check this README
- **AI Issues:** Verify your Cohere API key and quota

---

**Built with ❤️ using Laravel 12, Vue.js 3, and Cohere AI** 