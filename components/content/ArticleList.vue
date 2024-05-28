<template>
    <div class="my-5">
        <ContentList v-slot="{ list }" :query="query">
            <div v-for="article in list" :key="article._path">
                <h4 class="mb-0"><NuxtLink :to="article._path" class="text-primary-500">{{ article.title }}</NuxtLink></h4>
                <span v-if="article.publish_at" >{{ formatDate(article.publish_at) }}</span>
            </div>
        </ContentList>
    </div>
</template>
<script setup lang="ts">

import type { QueryBuilderParams } from '@nuxt/content/dist/runtime/types'

const query: QueryBuilderParams = { path: '/articles', where: [{ layout: 'article' }], sort: [{publish_at: -1}] }

const formatDate = (date: string) => useDateFormat(date, 'MMMM DD, YYYY').value

</script>