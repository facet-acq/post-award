<template>
  <div id="wrapper">
    <h1>Temp</h1>

    <button class="button is-primary" @click="count += 1;">Count is {{count}}</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      count: 0
    };
  }
}
</script>

<style>
body {
  padding-top:60px;
}
#wrapper {
  height:100vh;
}
</style>
