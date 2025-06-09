   <?php
   if (isset($message) && is_array($message)) {
      foreach ($message as $msg) {
         echo '
         <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <header class="header">
      <a href="dashboard.php" class="logo">PCBuildHub<span>Admin</span></a>
      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="components.php">Component Management</a>
         <a href="products.php">Products Management</a>
         <a href="guide_content.php">Guide Content Management</a>
         <a href="admin_prebuilt.php">Prebuilt Management</a>
         <a href="placed_orders.php">Orders Management</a>
         <a href="admin_accounts.php">Manage Admins</a>
         <a href="users_accounts.php">Manage Users</a>
         <a href="messages.php">Messages</a>
         <a href="components/admin_logout.php">Logout</a>
l      </nav>
   </header>


