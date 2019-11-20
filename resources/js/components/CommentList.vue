<template>
    <div>
        <div class="comment">
            <div class="d-flex justify-content-between">
                <span><strong>{{ comment.name }}</strong> <small>{{ comment.date_formated }}</small></span>
                <a href="#" @click.prevent="$bus.$emit('reply', comment)"><i class="fas fa-reply"></i></a>
            </div>

            <p class="mb-0">{{ comment.content }}</p>
        </div>

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
    }
}
</script>
