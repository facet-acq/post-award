<template>
  <div>
    <facet-navigation></facet-navigation>

    <section class="hero is-light is-bold">
      <div class="hero-body">
        <div class="container">
          <h1 class="title">Welcome to FACET</h1>
          <h2 class="subtitle">This is the Post-Award Module</h2>
        </div>
      </div>
    </section>

    <router-view></router-view>

    <flash-message></flash-message>

    <facet-footer></facet-footer>
  </div>
</template>

<script>
import FacetFooter from "./Footer.vue";
import FacetNavigation from "./NavBar.vue";
import FlashMessage from "./FlashMessage.vue";
export default {
  components: { FacetFooter, FacetNavigation, FlashMessage }
};
</script>
