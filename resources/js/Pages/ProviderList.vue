<template>
  <div class="container mx-auto py-6">
    <div class="mb-4 flex items-center gap-4">
      <input
        v-model="search"
        @input="debouncedFetch"
        type="text"
        placeholder="Search providers..."
        class="border rounded px-3 py-2 w-full max-w-md"
      />

      <select v-model="category" @change="fetchProviders" class="border rounded px-3 py-2">
        <option value="">All categories</option>
        <option v-for="cat in categories" :key="cat.slug" :value="cat.slug">
          {{ cat.name }}
        </option>
      </select>
    </div>

    <div v-if="loading" class="text-gray-500">Loading...</div>

    <div v-else-if="providers.length === 0" class="text-gray-500">No providers found.</div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="provider in providers"
        :key="provider.id"
        class="border rounded p-4 shadow hover:shadow-lg transition"
      >
        <img
          :src="provider.logo_url"
          alt="Logo"
          class="h-24 object-contain mx-auto mb-4"
          loading="lazy"
        />
        <h3 class="text-lg font-semibold">{{ provider.name }}</h3>
        <p class="text-gray-600 text-sm">{{ provider.description }}</p>
        <span class="text-xs text-blue-600 block mt-2">
          Category: {{ provider.category.name }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import debounce from 'lodash.debounce'

const providers = ref([])
const categories = ref([])
const search = ref('')
const category = ref('')
const loading = ref(false)

// Fetch providers with optional filters
const fetchProviders = async () => {
  loading.value = true
  try {
    const { data } = await axios.get('/api/providers', {
      params: {
        search: search.value,
        category: category.value,
      },
    })
    providers.value = data.data
  } catch (error) {
    console.error('Error fetching providers:', error)
  } finally {
    loading.value = false
  }
}

// Optional: fetch categories from API
const fetchCategories = async () => {
  try {
    const { data } = await axios.get('/api/categories')
    categories.value = data
  } catch (error) {
    console.warn('Categories could not be loaded:', error)
  }
}

// Debounced version of fetch
const debouncedFetch = debounce(fetchProviders, 400)

onMounted(() => {
  fetchProviders()
  fetchCategories()
})
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
