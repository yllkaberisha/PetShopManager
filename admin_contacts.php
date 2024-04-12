<?php
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

$messages_file = 'data/messages.php';
$messages = file_exists($messages_file) ? include($messages_file) : [];

function saveMessagesToFile($messages, $messages_file) {
    file_put_contents($messages_file, "<?php\nreturn " . var_export($messages, true) . ";\n");
}

if (isset($_GET['delete'])) {
    $delete_index = $_GET['delete'];
    // Remove the message using the index and re-index the array
    array_splice($messages, $delete_index, 1);
    saveMessagesToFile($messages, $messages_file);
    header('location:admin_contacts.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>

<section class="messages">
   <h1 class="title">Messages</h1>
   <div class="box-container">
      <?php foreach ($messages as $index => $message): ?>
      <div class="box">
         <p> user id : <span><?php echo htmlspecialchars($message['user_id']); ?></span> </p>
         <p> name : <span><?php echo htmlspecialchars($message['name']); ?></span> </p>
         <p> number : <span><?php echo htmlspecialchars($message['number']); ?></span> </p>
         <p> email : <span><?php echo htmlspecialchars($message['email']); ?></span> </p>
         <p> message : <span><?php echo htmlspecialchars($message['message']); ?></span> </p>
         <a href="admin_contacts.php?delete=<?php echo $index; ?>" onclick="return confirm('Delete this message?');" class="delete-btn">Delete message</a>
      </div>
      <?php endforeach; ?>
      <?php if (empty($messages)): ?>
          <p class="empty">You have no messages!</p>
      <?php endif; ?>
   </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>
