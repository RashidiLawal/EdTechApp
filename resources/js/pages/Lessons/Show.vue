<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const page = usePage();
const lesson = page.props.lesson as { id: number; title: string; content: string };
const user = page.props.auth.user as any;
const isAdmin = user && user.role && ['teacher', 'admin'].includes(user.role);

const question = ref('');
const answer = ref('');
const recommendations = ref<Array<{ id: number; title: string }>>([]);
const loading = ref(false);
const error = ref('');

async function askQuestion() {
  if (!question.value.trim()) return;
  loading.value = true;
  answer.value = '';
  error.value = '';
  try {
    const res = await axios.post(`/api/lessons/${lesson.id}/ask`, { question: question.value });
    if (res.data.answer) {
      answer.value = res.data.answer;
      recommendations.value = res.data.recommendations;
      question.value = '';
    } else {
      error.value = res.data.error || 'Sorry, there was a problem getting an answer.';
    }
  } catch (err) {
    const errorObj = err as any;
    error.value = errorObj.response?.data?.error || 'Sorry, there was a problem getting an answer.';
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto p-4">
    <!-- Breadcrumb Navigation -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="/lessons" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
            Lessons
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ lesson.title }}</span>
          </div>
        </li>
      </ol>
    </nav>

    <div class="grid lg:grid-cols-3 gap-8">
      <!-- Lesson Content -->
      <div class="lg:col-span-2">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
          <div class="flex justify-between items-start mb-6">
            <div>
              <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ lesson.title }}</h1>
              <p class="text-gray-600">Educational content for students</p>
            </div>
            <div v-if="isAdmin" class="flex gap-2">
              <a :href="route('lessons.edit', lesson.id)" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                Edit
              </a>
            </div>
          </div>
          
          <div class="prose max-w-none">
            <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ lesson.content }}</div>
          </div>
        </div>
      </div>

      <!-- AI Chat Sidebar -->
      <div class="lg:col-span-1">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 sticky top-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Ask AI Assistant</h2>
          
          <form @submit.prevent="askQuestion" class="space-y-4">
            <div>
              <label for="lesson-question" class="block text-sm font-medium text-gray-700 mb-2">
                Ask a question about this lesson:
              </label>
              <textarea 
                id="lesson-question" 
                v-model="question" 
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-black" 
                placeholder="Type your question here..."
                :disabled="loading"
              ></textarea>
            </div>
            
            <button 
              type="submit" 
              class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors disabled:opacity-50" 
              :disabled="loading || !question.trim()"
            >
              <span v-if="loading" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Asking AI...
              </span>
              <span v-else>Ask Question</span>
            </button>
          </form>

          <!-- Error Message -->
          <div v-if="error" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
            <p class="text-red-600 text-sm">{{ error }}</p>
          </div>

          <!-- AI Answer -->
          <div v-if="answer" class="mt-6">
            <h3 class="font-semibold text-gray-900 mb-3">AI Answer:</h3>
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
              <p class="text-gray-800 text-sm leading-relaxed">{{ answer }}</p>
            </div>
          </div>

          <!-- Recommendations -->
          <div v-if="recommendations.length" class="mt-6">
            <h3 class="font-semibold text-gray-900 mb-3">Recommended Lessons:</h3>
            <ul class="space-y-2">
              <li v-for="rec in recommendations" :key="rec.id">
                <a 
                  :href="route('lessons.show', rec.id)" 
                  class="block text-blue-600 hover:text-blue-800 text-sm font-medium hover:bg-blue-50 p-2 rounded-md transition-colors"
                >
                  {{ rec.title }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 