<template>
    <div class="max-w-4xl px-4 py-10 m-auto bg-white sm:px-8 sm:shadow dark:bg-gray-800 ring-1 ring-gray-200 dark:ring-gray-700 sm:rounded-lg">
        <main class="max-w-none prose dark:prose-invert prose-pre:bg-gray-100 dark:prose-pre:bg-gray-900 hover:prose-a:text-primary-400 prose-a:font-normal prose-a:no-underline prose-a:border-dashed prose-a:border-b hover:prose-a:border-solid hover:prose-a:border-primary-400">        
            <slot />
            <ContentList v-slot="{ list }" :query="query">
                <div v-for="article in list" :key="article._path">
                    <h3 class="mb-0"><NuxtLink :to="article._path" class="text-primary-500">{{ article.title }}</NuxtLink></h3>
                    <span>{{ article.description }}</span>
                </div>
            </ContentList>
        </main>
    </div>
</template>
<script setup lang="ts">
import type { QueryBuilderParams } from '@nuxt/content/dist/runtime/types'

const query: QueryBuilderParams = { path: '/articles', where: [{ layout: 'article' }] }
</script>