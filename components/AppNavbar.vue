<script lang="ts" setup>
  const {socials } = useAppConfig()
</script>

<template>
  <div class="flex justify-between max-w-4xl px-4 py-4 mx-auto sm:px-8">
    <!-- Navigation -->
    <div class="text-gray-700 dark:text-gray-200">
      <ContentNavigation v-slot="{ navigation }">
        <NuxtLink
          v-for="link of navigation"
          :key="link._path"
          :to="link._path"
          active-class="font-bold text-primary-500 dark:text-primary-400"
          class="mr-6"
        >
          {{ link.title }}
        </NuxtLink>
      </ContentNavigation>
    </div>
    <!-- Social icons & Color Mode -->
    <div class="space-x-3 transition text-gray-500">
      <a v-if="socials.twitter" target="_blank" :href="`https://x.com/${socials.twitter}`" title="Twitter" class="dark:text-gray-100 hover:text-gray-700 dark:hover:text-gray-300"><Icon name="fa6-brands:x-twitter" class="w-5 h-5" /></a>
      <a v-if="socials.github" target="_blank" :href="`https://github.com/${socials.github}`" title="GitHub" class="dark:text-gray-100 hover:text-gray-700 dark:hover:text-gray-300"><Icon name="fa6-brands:github" class="w-5 h-5" /></a>
      <a v-if="socials.linkedin" target="_blank" :href="`https://linkedin.com/in/${socials.linkedin}`" title="LinkedIn" class="dark:text-gray-100 hover:text-gray-700 dark:hover:text-gray-300"><Icon name="fa6-brands:linkedin" class="w-5 h-5" /></a>
      <ColorModeSwitch class="dark:text-gray-100 hover:text-gray-700 dark:hover:text-gray-300" />
    </div>
  </div>
</template>
