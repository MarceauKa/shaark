<template>
    <div>
        <div class="comment">
            <div class="d-flex justify-content-between">
                <span>
                    <i class="fas fa-exclamation-triangle mr-1" v-if="unvisibleComment"></i>
                    <strong>{{ comment.name }}</strong>
                    <small>{{ comment.date_formated }}</small>
                </span>
                <span>
                    <confirm tag="a"
                             class="text-info mr-1"
                             v-if="unvisibleComment"
                             :text="`<i class='fas fa-user-check fa-fw'></i>`"
                             :text-confirm="`<i class='fas fa-check fa-fw'></i>`"
                             @confirmed="$bus.$emit('moderate', comment)"
                    ></confirm>
                    <confirm tag="a"
                             class="text-info mr-1"
                             v-if="isLogged()"
                             :text="`<i class='fas fa-trash-alt fa-fw'></i>`"
                             :text-confirm="`<i class='fas fa-check fa-fw'></i>`"
                             @confirmed="$bus.$emit('delete', comment)"
                    ></confirm>
                    <a href="#" class="text-info" @click.prevent="$bus.$emit('reply', comment)"><i class="fas fa-reply"></i></a>
                </span>
            </div>

            <p class="mb-0">{{ comment.content }}</p>
        </div>

        <comment v-if="comment.comments.length > 0"
                 class="replies"
                 v-for="item in comment.comments"
                 :comment="item"
                 :key="item.id"
        ></comment>
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

    computed: {
        unvisibleComment() {
            return this.isLogged()
                && this.comment.is_visible === false;
        }
    },
}
</script>
