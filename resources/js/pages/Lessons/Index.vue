<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();
const lessons = page.props.lessons as Array<{ id: number; title: string; content: string }>;

function destroy(id: number) {
  if (confirm('Are you sure you want to delete this lesson?')) {
    router.delete(route('lessons.destroy', id));
  }
}
</script>

<template>
  <div class="max-w-2xl mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Lessons</h1>
      <a href="/lessons/create" class="bg-blue-600 text-white px-4 py-2 rounded">Create Lesson</a>
    </div>
    <ul>
      <li v-for="lesson in lessons" :key="lesson.id" class="border-b py-2 flex justify-between items-center">
        <div>
          <a :href="route('lessons.show', lesson.id)" class="font-medium text-blue-700 hover:underline">{{ lesson.title }}</a>
        </div>
        <div class="space-x-2">
          <a :href="route('lessons.edit', lesson.id)" class="text-sm text-yellow-600 hover:underline">Edit</a>
          <button @click="destroy(lesson.id)" class="text-sm text-red-600 hover:underline">Delete</button>
        </div>
      </li>
    </ul>
  </div>
</template> 