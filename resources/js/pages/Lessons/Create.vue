<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  content: '',
});

function submit() {
  form.post(route('lessons.store'));
}
</script>

<template>
  <div class="max-w-xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create Lesson</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block mb-1 font-medium">Title</label>
        <input v-model="form.title" type="text" class="w-full border rounded p-2" />
        <div v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</div>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-medium">Content</label>
        <textarea v-model="form.content" class="w-full border rounded p-2" rows="6"></textarea>
        <div v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</div>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded" :disabled="form.processing">
        Create Lesson
      </button>
    </form>
  </div>
</template> 