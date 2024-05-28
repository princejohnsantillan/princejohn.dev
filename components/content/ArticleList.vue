<template>
    <ContentList v-slot="{ list }" :query="query">
        <div v-for="article in list" :key="article._path">
            <h3 class="mb-0"><NuxtLink :to="article._path" class="text-primary-500">{{ article.title }}</NuxtLink></h3>
            <span v-if="article.publish_at" >{{ formatDate(article.publish_at) }}</span>
        </div>
    </ContentList>
</template>
<script setup lang="ts">

const query: QueryBuilderParams = { path: '/articles', where: [{ layout: 'article' }], sort: [{publish_at: -1}] }

const formatDate = (date: string) => useDateFormat(date, 'MMMM DD, YYYY').value

</script>