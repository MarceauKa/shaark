<template>
    <div class="card card--comments">
        <div class="card-header">{{ __('Comments') }}</div>
        <div class="card-body">
            <loader :loading="loading" v-if="loading"></loader>
            <div v-else>
                <div class="alert alert-info mb-0"
                     v-if="comments.length === 0"
                >{{ __('No comments') }}</div>

                <comment-list
                    v-for="comment in comments"
                    :comment="comment"
                    :key="comment.id"
                ></comment-list>
            </div>
        </div>
    </div>
</template>

<script>
import httpErrors from "../mixins/httpErrors";

export default {
    mixins: [
        httpErrors,
    ],

    props: {
        id: {
            type: Number,
            required: true,
        }
    },

    mounted() {
        this.fetch();
    },

    data() {
        return {
            loading: true,
            comments: [],
        }
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get(`/api/comments/${this.id}`)
                .then(response => {
                    this.comments = this.nested(response.data.comments);
                    this.loading = false;
                })
                .catch(error => {
                    this.setHttpError(error);
                    this.toastHttpError();
                    this.loading = false;
                });
        },

        nested(items, id = null, link = 'comment_id') {
            return items
                .filter(item => item[link] === id)
                .map(item => ({...item, comments: this.nested(items, item.id)}));
        },

        nest(items) {
            let tree = [],
                itemsMap = {},
                item,
                mappedItem;

            for (let i = 0, length = items.length; i < length; i++) {
                item = items[i];
                itemsMap[item.id] = item;
                itemsMap[item.id]['comments'] = [];
            }

            for (let id in itemsMap) {
                if (itemsMap.hasOwnProperty(id)) {
                    mappedItem = itemsMap[id];
                    if (mappedItem.comment_id) {
                        itemsMap[mappedItem['comment_id']]['comments'].push(mappedItem);
                    } else {
                        tree.push(mappedItem);
                    }
                }
            }
            return tree;
        }
    }
}
</script>
