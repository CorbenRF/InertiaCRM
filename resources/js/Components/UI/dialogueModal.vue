<template>
  <div class="backdrop-confirm" @click.self="$emit('close')" @keydown.esc="$emit('close')">
    <div class="modal-custom-confirm container-md">
      <slot class="modal-custom-confirm__message">
        <div class="dialogue__modal">
          <span class="dialogue__modal-msg"
            >Вы уверены? <span class="dialogue__modal-bold"></span> -
            <span class="dialogue__modal-bold"></span>
          </span>
        </div>
      </slot>
      <div class="buttons-group">
        <button type="button" class="btn btn-success" @click="$emit('answer', 1)">Да</button>

        <button type="button" class="btn btn-danger" @click="$emit('answer', 0)">Нет</button>

        <button type="button" class="btn btn-dark" @click="$emit('close')">Отмена</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
};
</script>
<style lang="scss">
.modal-custom-confirm {
  position: relative;
  padding: 3rem !important;
  height: auto;
  border: 1px blue solid;
  border-radius: 40px;
  // background-color: rgba($color: #555, $alpha: 0.2);
  z-index: 500;
  background: #ffffff;
  box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  &__message {
    margin-bottom: 2rem;
  }
  & > .buttons-group {
    display: flex;
    min-width: 30%;
    max-width: 400px;
    flex-direction: column;

    & :not(:last-child) {
      margin-bottom: 2rem;
    }
  }
}

.backdrop-confirm {
  z-index: 1000;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}

.dialogue {
  &__modal {
    margin-bottom: 2rem;
    &-msg {
      font-size: medium;
    }
    &-bold {
      font-size: large;
      font-weight: bold;
    }
  }
}
</style>
