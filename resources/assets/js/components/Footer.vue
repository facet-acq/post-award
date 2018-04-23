<template>
  <footer class="footer">
    <div class="container">
      <div class="content has-text-centered">
        <strong>FACET-Acq</strong> is designed to manage the 'post-award' portion of the Procurement-to-Payment business process.
        <p>
          <strong>FACET-Acq</strong> is an open source community project managed via <a href="https://github.com/facet-acq/post-award">GitHub 
          <span class="icon">
            <i class="fa fa-github"></i>
          </span>
          </a> and <strong>not</strong> an official organizaiton of the US government.
        </p>
        <p>Copyright 2017-{{currentYear}}, Daniel Furman.</p>
        <p>All Rights Reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script>
import moment from 'moment';
export default {
  data() {
    return {
      currentYear: moment().format('YYYY')
    };
  }
}
</script>

