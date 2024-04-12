<?php
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

$users_file = 'data/user_data.php';
$users = file_exists($users_file) ? include($users_file) : [];

function saveUsersToFile($users, $users_file) {
    file_put_contents($users_file, "<?php\nreturn " . var_export($users, true) . ";\n");
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $users = array_filter($users, function($user) use ($delete_id) {
        return $user['id'] != $delete_id;
    });
    $users = array_values($users); // Re-index array after filtering
    saveUsersToFile($users, $users_file);
    header('location:admin_users.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>

<section class="users">
   <h1 class="title">User Accounts</h1>
   <div class="box-container">
      <?php foreach ($users as $user): ?>
      <div class="box">
         <p> user id : <span><?php echo $user['id']; ?></span> </p>
         <p> username : <span><?php echo $user['name']; ?></span> </p>
         <p> email : <span><?php echo $user['email']; ?></span> </p>
         <p> user type : <span style="color:<?php if ($user['user_type'] == 'admin') { echo 'var(--orange)'; } ?>"><?php echo $user['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">delete user</a>
      </div>
      <?php endforeach; ?>
      <?php if (empty($users)): ?>
          <p class="empty">No users found.</p>
      <?php endif; ?>
   </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>
