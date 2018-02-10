<template>
  <div>
    <h1>Temp</h1>

    <span @click="count += 1;">Count is {{count}}</span>
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

