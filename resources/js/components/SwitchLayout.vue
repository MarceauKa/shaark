
<template>
    <div class="col-12 mode mb-2">
        <span :class="{ active: !isSimple }" @click="setLayout('preview')">
            <i class="fa fa-newspaper-o"></i> 
        </span>
        <span :class="{ active: isSimple }" @click="setLayout('simple')">
            <i class="fa fa-th-list"></i>
        </span>
    </div>
</template>

<script>
export default {
    computed: {
        isSimple() {
            if(localStorage.getItem('layout') === 'simple') {
                return true;
            }

            return false;
        }
    },

    methods: {
        setLayout(layout) {
            localStorage.setItem('layout', layout);
            location.reload();
        }
    }
}
</script>
