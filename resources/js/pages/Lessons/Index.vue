<script setup lang="ts">
import { usePage, router, Link } from '@inertiajs/vue3';

const page = usePage();
const lessons = page.props.lessons as Array<{ id: number; title: string; content: string }>;
const user = page.props.auth.user as any;
const isAdmin = user && user.role && ['teacher', 'admin'].includes(user.role);

function destroy(id: number) {
  if (confirm('Are you sure you want to delete this lesson?')) {
    router.delete(route('lessons.destroy', id));
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Lessons</h1>
        <p class="text-gray-600 mt-1">Browse and learn from our educational content</p>
      </div>
      <div v-if="isAdmin" class="flex gap-2">
        <Link href="/lessons/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Lesson
          </span>
        </Link>
      </div>
    </div>

    <div v-if="lessons.length === 0" class="text-center py-12">
      <div class="text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No lessons yet</h3>
        <p class="mt-1 text-sm text-gray-500">
          {{ isAdmin ? 'Get started by creating your first lesson.' : 'Lessons will appear here once they are created.' }}
        </p>
        <div v-if="isAdmin" class="mt-6">
          <Link href="/lessons/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            Create Lesson
          </Link>
        </div>
      </div>
    </div>

    <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div v-for="lesson in lessons" :key="lesson.id" class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            <a :href="route('lessons.show', lesson.id)" class="hover:text-blue-600 transition-colors">
              {{ lesson.title }}
            </a>
          </h3>
          <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {{ lesson.content.substring(0, 150) }}{{ lesson.content.length > 150 ? '...' : '' }}
          </p>
          <div class="flex justify-between items-center">
            <a :href="route('lessons.show', lesson.id)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
              Read Lesson →
            </a>
            <div v-if="isAdmin" class="flex gap-2">
              <a :href="route('lessons.edit', lesson.id)" class="text-yellow-600 hover:text-yellow-800 text-sm">
                Edit
              </a>
              <button @click="destroy(lesson.id)" class="text-red-600 hover:text-red-800 text-sm">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 