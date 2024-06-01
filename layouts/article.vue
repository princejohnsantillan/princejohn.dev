<template>
    <div class="max-w-4xl px-4 py-10 m-auto bg-white sm:px-8 sm:shadow dark:bg-gray-800 ring-1 ring-gray-200 dark:ring-gray-700 sm:rounded-lg">
      <main class="max-w-none prose dark:prose-invert prose-pre:bg-gray-100 dark:prose-pre:bg-gray-900 hover:prose-a:text-primary-400 prose-a:font-normal prose-a:no-underline prose-a:border-dashed prose-a:border-b hover:prose-a:border-solid hover:prose-a:border-primary-400">        
        <div class="my-10">
            <h1 class="mb-0 text-primary-500">{{ page.title }}</h1>
            <span v-if="publish_date" class="text-sm">Published on {{ publish_date }}</span>        
        </div>

        <slot />
      </main>
    </div>
</template>
<script setup>
    const { page } = useContent()
    
    const publish_date = computed(() => page.value.publishAt ? useDateFormat(page.value.publishAt, 'MMMM DD, YYYY').value : null)
</script>
  