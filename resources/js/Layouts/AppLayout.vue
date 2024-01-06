<!-- eslint-disable -->
<template>
    <nav class="container">
      <!-- <div class="d-flex flex-wrap align-items-center justify-content-center"> -->
      <ul class="nav col-12 col-lg-auto my-2 justify-content-around my-md-0">
        <li>
          <div @click="this.modalVisible = true" class="nav-link text-secondary">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi d-block mx-auto mb-1 bi-plus-square"
              viewBox="0 0 16 16"
            >
              <path
                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
              />
              <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
              />
            </svg>
            Новая заявка
          </div>
        </li>
        <li>
          <Link :href="route('history')" class="nav-link text-secondary"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi d-block mx-auto mb-1 bi-clock"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"
              />
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
            </svg>
            История</Link
          >
        </li>
        <li>
          <Link :href="route('catalogues')" class="nav-link text-secondary"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi d-block mx-auto mb-1 bi-book"
              viewBox="0 0 16 16"
            >
              <path
                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"
              /></svg
            >Каталог</Link
          >
        </li>
        <li>
        <!-- made a temporary div instead of router-link. should make a programmable popup in the future -->
          <div to="/notifications" class="nav-link text-secondary"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi d-block mx-auto mb-1 bi-0-circle"
              viewBox="0 0 16 16"
            >
              <path
                d="M7.988 12.158c-1.851 0-2.941-1.57-2.941-3.99V7.84c0-2.408 1.101-3.996 2.965-3.996 1.857 0 2.935 1.57 2.935 3.996v.328c0 2.408-1.101 3.99-2.959 3.99ZM8 4.951c-1.008 0-1.629 1.09-1.629 2.895v.31c0 1.81.627 2.895 1.629 2.895s1.623-1.09 1.623-2.895v-.31c0-1.8-.621-2.895-1.623-2.895Z"
              />
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Z" /></svg
            >Уведомления</div
          >
        </li>
        <li>
          <Link
          :href="route('logout')" method="post" as="button"
              class="nav-link text-secondary"
              >
          <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi d-block mx-auto mb-1 bi-door-open"
              viewBox="0 0 16 16"
            >
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
              <path
                d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"
              /></svg
            >
            Выход
          </Link>
        </li>

      </ul>
      <!-- </div> -->
    </nav>
    <tableModal v-if="modalVisible" :id="0" :readOnlyDefault="false" @close="closeModal" />
    <article>
        <slot></slot>
    </article>
  </template>

  <script>
  import { Link } from '@inertiajs/vue3';
  import tableModal from '@/components/UI/tableModal.vue';

  export default {
  components: {
      Link,
      tableModal
    },
    data() {
      return {
        loadingFinished: false,
        modalVisible: false,
      };
    },
    methods: {
      closeModal() {
        this.modalVisible = false;
        this.loadingFinished = false;
      },
    },
  };
  </script>
  <style lang="scss">
  nav {
    margin-top: 1em;
    color: #000;
  }
  li > .nav-link {
    cursor: pointer !important;
  }
  </style>
