<template>
  <div>
    <VueMultiselect
      :name="name"
      :modelValue="modelValue"
      :options="catalogue"
      :aria-label="label"
      :disabled="readOnly"
      :placeholder="label"
      selectLabel="Enter чтобы выбрать"
      tagPlaceholder="Enter чтобы создать"
      deselectLabel=""
      selectedLabel="Выбрано"
      label="name"
      track-by="name"
      :taggable="taggable"
      :loading="this.innerLoading"
      :allowEmpty="false"
      @select="(arg, id) => $emit('update:modelValue', arg)"
      @tag="askToCreate"
    >
      <template #noResult><span>По Вашему запросу ничего не найдено...</span></template>
    </VueMultiselect>

    <!-- want to create slot in confirmation dialogue with custom question -->
    <dialogueModal v-if="confirmVisible" @answer="getAnswer" @close="this.confirmVisible = false">
      <div class="dialogue__modal">
        <span class="dialogue__modal-msg"
          >Вы уверены, что хотите создать элемент списка
          <span class="dialogue__modal-bold">{{ catalogueRuName }}</span> -
          <span class="dialogue__modal-bold">{{ tagToCreate }}</span>
        </span>
      </div>
    </dialogueModal>
  </div>
</template>

<script>
import serverFunc from '@/mixins/serverFunc.vue';
import VueMultiselect from 'vue-multiselect';
import dialogueModal from './dialogueModal.vue';

export default {
  emits: ['update-data', 'update:modelValue'],
  data() {
    return {
      innerLoading: false,
      confirmVisible: false,
      confirmAnswer: null,
      tagToCreate: '',
    };
  },
  props: [
    'modelValue',
    'catalogue',
    'item',
    'label',
    'readOnly',
    'name',
    'catalogueName',
    'catalogueRuName',
    'taggable',
  ],
  components: {
    VueMultiselect,
    dialogueModal,
  },
  mixins: [serverFunc],
  methods: {
    getAnswer(val) {
      this.confirmAnswer = val;
      this.confirmVisible = false;
      this.createSelectOption();
    },
    askToCreate(newTag) {
      console.log('asking for confirmation');
      this.confirmVisible = true;
      this.tagToCreate = newTag;
    },
    async createSelectOption() {
      if (this.confirmAnswer) {
        console.log(this.tagToCreate, this.catalogueName, this.item);
        const tag = {
          name: this.tagToCreate,
          id: 0,
        };
        this.innerLoading = true;
        const result = await this.createCatalogueEntry(this.catalogueName, tag);
        console.log(result);
        this.$store
          .dispatch('fetchCatalogue', this.catalogueName)
          .then((this.innerLoading = false));
        this.$emit('update-data', this.item, {
          name: this.tagToCreate,
          id: result.id,
        });
      }
      this.tagToCreate = '';
    },
  },
};
</script>

<style lang="scss">
@import 'vue-multiselect/dist/vue-multiselect.css';

.multiselect {
  &__disabled > * {
    opacity: 1;
    background-color: #e9ecef !important;
  }
}
</style>
