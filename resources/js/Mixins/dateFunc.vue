<script>
export default {
  methods: {
    makeShortDate(dateObj) {
      if (dateObj) {
        const newDate = dateObj.slice(0, 10).split('-');
        return `${newDate[0]}-${newDate[1]}-${newDate[2]}`;
      }
      return null;
    },
    makeStringDate(dateObj) {
      if (dateObj) {
        const newDate = dateObj.slice(0, 10).split('-');
        return `${newDate[2]}.${newDate[1]}.${newDate[0]}`;
      }
      return null;
    },
    makeStandardDate(dateStr) {
      // for sending to server use only (because of null)
      if (dateStr) {
        const newDate = this.makeShortDate(dateStr);
        return `${newDate} 12:00:00`;
        // 2004-11-20T19:00:00.000Z
      }
      return null;
    },
  },
};
</script>
