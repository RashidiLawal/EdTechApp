<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
  title: '',
  content: '',
});

function submit() {
  form.post(route('lessons.store'));
}
</script>

<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto p-4">
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
              <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Create Lesson</span>
            </div>
          </li>
        </ol>
      </nav>

      <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-gray-900">Create New Lesson</h1>
          <p class="text-gray-600 mt-1">Add educational content for your students</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Lesson Title</label>
            <input 
              id="title"
              v-model="form.title" 
              type="text" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900" 
              placeholder="Enter lesson title..."
              required
            />
            <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</div>
          </div>

          <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Lesson Content</label>
            <textarea 
              id="content"
              v-model="form.content" 
              rows="8"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900" 
              placeholder="Enter the lesson content here..."
              required
            ></textarea>
            <div v-if="form.errors.content" class="mt-1 text-sm text-red-600">{{ form.errors.content }}</div>
          </div>

          <div class="flex gap-3">
            <button 
              type="submit" 
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors disabled:opacity-50" 
              :disabled="form.processing"
            >
              <span v-if="form.processing" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Creating...
              </span>
              <span v-else>Create Lesson</span>
            </button>
            <a 
              href="/lessons" 
              class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition-colors"
            >
              Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template> 