<template>
    <div>
        <blockquote class="blockquote">
            <p class="mb-0">{{ comment.content }}</p>
            <footer class="blockquote-footer">{{ comment.name }}, {{ comment.date_formated }}</footer>
        </blockquote>
        <comment-list v-if="comment.comments.length > 0"
                      class="replies"
                      v-for="item in comment.comments"
                      :comment="item"
                      :key="item.id"
        ></comment-list>
    </div>
</template>

<script>
export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },
}
</script>
