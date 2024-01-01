<template>
    <div>
    <button type="button" class="btn btn-primary">
        {{ item.client_entry_num }}
    </button>

    </div>
</template>

<script>
export default {
    props: ['item'],

}
</script>
