<?php include "./components/head.php" ?>

<div class="navbar bg-base-100">
  <div class="flex-1">
    <?php
    if (Validator::Role('student')) {
      echo '
      <a href="/dashboard" class="btn btn-ghost mr-3">Dashboard</a>
      <a href="/logout" class="btn btn-ghost mr-3">Logout</a>';
    } else if (Validator::Role('teacher')) {
      echo '
      <a href="/dashboard" class="btn btn-ghost mr-3">Dashboard</a>
      <a href="/logout" class="btn btn-ghost mr-3">Logout</a>';
      
    }
    ?>
  </div>
</div>