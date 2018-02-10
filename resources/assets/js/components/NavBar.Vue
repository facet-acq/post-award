<template>
  <nav class="navbar is-primary is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a href="https://github.com/facet-acq" class="navbar-item">
         <img src="" alt="FACET Acquistion a fractal approach to ">
        </a>
    </div>

    <button class="button navbar-burger">
        <router-link v-for="item in menu" :to="item.link" :key="item.label"><span>{{item.label}}</span></router-link>
    </button>

      <div class="navbar-menu">

      </div>
</nav>
</template>

<script>
export default {
  data() {
    return {
      menu: [
        { label: "Home", link: "/" },
        { label: "About", link: "/temp" },
        { label: "Login", link: "/login" }
      ]
    };
  }
};
</script>

