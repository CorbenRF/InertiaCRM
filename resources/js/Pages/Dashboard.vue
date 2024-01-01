
<template>
    <Head title="Dashboard" />

        <div class="container-fluid min-vh-100">

            <appNav />
            <div class="p-6 text-gray-900">You're logged in!</div>
        </div>

</template>

<script>
// @ is an alias to /src
import appNav from '@/components/UI/appNav.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
  name: 'Dashboard',
  components: {
    appNav,
    Head,
    Link,
  },

};
</script>


<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #000;
}

nav {
  padding: 30px;
  margin-top: 1em;
  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
