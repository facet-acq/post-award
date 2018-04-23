<template>
  <div>
    <facet-navigation></facet-navigation>
    
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
