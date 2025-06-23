<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const page = usePage();
const lesson = page.props.lesson as { id: number; title: string; content: string };

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
  <div class="max-w-xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ lesson.title }}</h1>
    <div class="mb-4 whitespace-pre-line">{{ lesson.content }}</div>

    <div class="mt-8 p-4 border rounded bg-gray-50">
      <form @submit.prevent="askQuestion" class="flex flex-col gap-2">
        <label for="lesson-question" class="font-semibold">Ask a question about this lesson:</label>
        <input id="lesson-question" v-model="question" type="text" class="border rounded p-2 text-black" placeholder="Type your question..." :disabled="loading" autocomplete="off" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded self-start" :disabled="loading || !question.trim()">
          {{ loading ? 'Asking...' : 'Ask' }}
        </button>
      </form>
      <div v-if="error" class="text-red-500 mt-2">{{ error }}</div>
      <div v-if="answer" class="mt-4">
        <div class="font-medium mb-1">AI Answer:</div>
        <div class="bg-white border rounded p-3 text-black">{{ answer }}</div>
      </div>
      <div v-if="recommendations.length" class="mt-4">
        <div class="font-medium mb-1">Recommended Lessons:</div>
        <ul class="list-disc pl-5">
          <li v-for="rec in recommendations" :key="rec.id">
            <a :href="route('lessons.show', rec.id)" class="text-blue-700 hover:underline">{{ rec.title }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template> 