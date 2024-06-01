---
layout: article
publishAt: "2024-05-28"
ogImage: true
---

I just migrated my personal site from [Statamic](https://statamic.com/) into [Nuxt](https://nuxt.com/). I am using the `nuxt-content` module configured to be [`document driven`](https://content.nuxt.com/document-driven/introduction/).

I was initially drawn to the Notion-like block-based rich text editor of [Nuxt Studio](https://nuxt.studio/), so I played with it using its `content-wind` template. I also liked that you could host your static content using Github pages and use your own custom domain. This was perfect for me who is just starting out with blogging; no-cost and efficient workflow!

Unfortunately, after a couple of days of tinkering with Nuxt studio I encountered a few unrefined functionalities:

- Switching between markdown and rich editor is a bit slow 😐
- Live preview caching was consistently inconsistent 😢
- Custom domain with Github pages was buggy 😤

Because of those issues, I decided to drop Nuxt studio. I'd like to revisit it once functionalities are more refined.

The good thing is in the process I got my feet wet with `nuxt-content` specifically its `document driven` mode. And I love it! 😍 So my take away was leverage the power and beauty of this framework and just deploy everything on my own using [Vercel](https://vercel.com/), which is still no-cost and efficient. By the way, it was because of Nuxt studio's chat support that I discovered Vercel! With Vercel I also have extra analytics and speed insights available 🎉🤩.

Don't get me wrong, Statamic is also a great CMS! It is built on top of Laravel so it has a lot of features included out of the box! But that is the thing, for my use case I wanted a _simple_, _basic_, and _for blogging only_ codebase. So a static site generator like `nuxt-content` was perfect for me. Besides with Nuxt I can build on top of it if/when needed, I can even have Laravel as my backend.

In conclusion, I love my new setup for my needs right now. I love both Laravel and Nuxt and I will utilize both where they fit the use case.
