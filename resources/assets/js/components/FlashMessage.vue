<template>
  <article v-show="show" class="message is-info alert-flash">
    <div class="message-header">
      <p>Info</p>
      <button class="delete" aria-label="delete"></button>
    </div>
    <div class="message-body">
      {{ body }}
    </div>
  </article>
</template>

<script>
export default {
  props: ['message'],

  data() {
    return {
      body: '',
      show: false
    }
  },

  created() {
    if (this.message) {
      this.flash(this.message);
    }

    window.eventHub.$on('flash', message => this.flash(message));
  },

  methods: {
    flash(message) {
      this.body = message;
      this.show = true;
      this.hide();
    },

    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    }
  }
}
</script>

<style>
  .alert-flash {
    position: fixed;
    right: 25px;
    bottom: 25px;
  }
</style>

