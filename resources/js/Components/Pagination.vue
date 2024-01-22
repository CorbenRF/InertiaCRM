<template>
<div v-if="links.length > 3" class="pagination">
    <div class="page-item" v-for="(link, key) in links" >
        <div :key="key" v-if="link.url === null" class="page-link disabled" v-html="link.label" />
        <Link v-else class="page-link" :class="{ active: link.active }" :href="link.url" v-html="link.label" />
    </div>
</div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";

export default {
props: {
    links: Array,
},
components : {
    Link,
}
}
</script>

<style lang="scss">
    .pagination {
        justify-content: center;
    }
</style>
