<script>
import axios from 'axios';

export default {
  /* eslint-disable */
  methods: {
    async updateForm(path, form, id) {
      try {
        const response = await axios.put(`${this.$store.state.BASE_URL}/${path}?id=${id}`, form);
        return response.data;
      } catch (error) {
        return error;
      }
    },

    async postForm(path, form) {
      try {
        const response = await axios.post(`${this.$store.state.BASE_URL}/${path}`, form);
        return response.data;
      } catch (error) {
        return error;
      }
    },

    async fetchEntry(catalogue, id) {
      try {
        const response = await axios.get(`${this.$store.state.BASE_URL}/${catalogue}?id=${id}`);
        return response.data;
      } catch (error) {
        return error;
      }
    },

    async deleteCatalogueEntry(catalogue, id) {
      try {
        const response = await axios.delete(`${this.$store.state.BASE_URL}/${catalogue}?id=${id}`);
        return response.data;
      } catch (error) {
        return error;
      }
    },

    async createCatalogueEntry(catalogue, entry) {
      try {
        const response = await axios.post(`${this.$store.state.BASE_URL}/${catalogue}`, entry);
        return response.data;
      } catch (error) {
        return error;
      }
    },
  },
};
</script>
