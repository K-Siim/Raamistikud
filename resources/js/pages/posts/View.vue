    <script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Textarea } from '@/components/ui/textarea';
import { edit, index, show } from '@/routes/posts';
import { add } from '@/routes/comments';
import type { BreadcrumbItem } from '@/types';


interface Comment {
  id: number;
  post_id: number;
  user_id: number;
  content: string;
  created_at: string;
  user?: {
    id: number;
    name: string;
  } | null;
}

const props = defineProps<{
  post: {
    id: number;
    title: string;
    content: string;
    author_id: number;
    author: {
      id: number;
      first_name: string;
      last_name: string;
    };
    published: boolean;
    created_at: string;
    updated_at: string;
    created_at_formatted: string;
    updated_at_formatted: string;
    comments: Comment[];
  };
}>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Posts', href: index().url },
  { title: props.post.title, href: show.url(props.post.id) },
];

const statusLabel = computed(() => (props.post.published ? 'Published' : 'Draft'));
const statusClasses = computed(() =>
  props.post.published
    ? 'bg-emerald-100 text-emerald-700 border border-emerald-200'
    : 'bg-slate-100 text-slate-600 border border-slate-200',
);

const hasComments = computed(() => props.post.comments.length > 0);

const commentAuthor = (comment: Comment) => comment.user?.name ?? 'Anonymous';
const authorInitial = (comment: Comment) => commentAuthor(comment).charAt(0).toUpperCase();


const form = useForm({
  content: '',
});

const submit = () => {
  form.post(add(props.post.id).url, {
    preserveScroll:true,
    onSuccess: () => {
      form.reset();
    },
  });
};


</script>

<template>
  <Head :title="props.post.title" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-col items-center gap-6 overflow-x-auto p-6">
      <div class="w-full max-w-3xl space-y-8">
        <!-- Blog header -->
        <header class="space-y-4 rounded-xl border border-border/60 bg-card p-8 shadow-sm">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="space-y-3">
              <span class="inline-flex items-center rounded-full bg-muted px-3 py-1 text-xs font-medium uppercase tracking-wide text-muted-foreground">
                Blog Post
              </span>

              <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ props.post.title }}
              </h1>

              <p class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground">
                <span>Written by</span>
                <span class="font-medium text-foreground">
                  {{ props.post.author.first_name }} {{ props.post.author.last_name }}
                </span>
                <span class="text-xs text-border">•</span>
                <span>
                  Published
                  <span class="font-medium text-foreground">{{ props.post.created_at_formatted }}</span>
                </span>
              </p>
            </div>

            <div class="flex flex-col items-end gap-3">
              <span
                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide"
                :class="statusClasses"
              >
                {{ statusLabel }}
              </span>

              <div class="flex flex-wrap items-center gap-2">
                <Button as-child size="sm" variant="outline">
                  <Link :href="edit.url(props.post.id)">Edit Post</Link>
                </Button>

                <Button as-child size="sm" variant="ghost">
                  <Link :href="index().url">Back to Posts</Link>
                </Button>
              </div>
            </div>
          </div>

          <dl class="mt-4 grid gap-4 border-t border-border/40 pt-4 text-xs text-muted-foreground sm:grid-cols-3">
            <div class="space-y-1">
              <dt class="uppercase tracking-wide">Created</dt>
              <dd class="space-y-0.5 text-foreground">
                <div class="text-sm">{{ props.post.created_at_formatted }}</div>
                <div class="text-xs text-muted-foreground">{{ props.post.created_at }}</div>
              </dd>
            </div>

            <div class="space-y-1">
              <dt class="uppercase tracking-wide">Last updated</dt>
              <dd class="space-y-0.5 text-foreground">
                <div class="text-sm">{{ props.post.updated_at_formatted }}</div>
                <div class="text-xs text-muted-foreground">{{ props.post.updated_at }}</div>
              </dd>
            </div>

            <div class="space-y-1">
              <dt class="uppercase tracking-wide">Post ID</dt>
              <dd class="text-sm text-foreground">#{{ props.post.id }}</dd>
            </div>
          </dl>
        </header>

        <section class="rounded-xl border border-border/60 bg-background p-8 shadow-sm">
          <article class="prose prose-slate max-w-none text-base leading-relaxed text-foreground/90 dark:prose-invert">
            <p class="whitespace-pre-line">
              {{ props.post.content }}
            </p>
          </article>
        </section>
      </div>

      <section class="w-full max-w-3xl rounded-xl border border-border/60 bg-background p-8 shadow-sm">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
          <div>
            <h3 class="text-lg font-semibold text-foreground">Comments</h3>
            <div class="pb-6">
              <form @submit.prevent="submit" id="comment-form">
                <Textarea v-model="form.content"></Textarea>
              </form>
              <div class="flex mt-4 justify-end">
                <Button form="comment-form" type="submit">Submit</Button>
              </div>
            </div>
            <p class="text-sm text-muted-foreground">
              {{ hasComments ? 'Join the conversation below.' : 'No comments yet — be the first to share your thoughts.' }}
            </p>
          </div>
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-muted text-sm font-semibold text-foreground">
            {{ props.post.comments.length }}
          </span>
        </div>

        <template v-if="hasComments">
          <ul class="space-y-4">
            <li
              v-for="comment in props.post.comments"
              :key="comment.id"
              class="rounded-xl border border-border/40 bg-muted/30 p-4"
            >
              <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-muted text-sm font-semibold text-foreground/80">
                  {{ authorInitial(comment) }}
                </div>
                <div class="flex-1 space-y-1">
                  <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground">
                    <span class="font-medium text-foreground">{{ commentAuthor(comment) }}</span>
                    <span class="text-xs text-border">•</span>
                    <span>{{ comment.created_at }}</span>
                  </div>
                  <p class="text-base text-foreground">{{ comment.content }}</p>
                </div>
              </div>
            </li>
          </ul>
        </template>
        <template v-else>
          <div class="rounded-lg border border-dashed border-border/70 bg-muted/30 p-6 text-center text-sm text-muted-foreground">
            No comments yet. Start the discussion by leaving the first comment.
          </div>
        </template>
      </section>
    </div>
  </AppLayout>
</template>
