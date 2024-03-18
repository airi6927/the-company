<?php
session_start();
require_once "../classes/User.php";

$user_obj = new User;
$all_users = $user_obj->getAllUsers();

//print_r($all_users);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- style css -->
    <link rel="stylesheet" href="../assets/css/style.css" class="">
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
        <div class="container">
            <a href="" class="navbar-brand">
                <!-- <h1 class="h3">The company</h1> -->
                <h3>The company</h3>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['fullname'] ?></span>
                <form action="../actions/logout-action.php" method="post" class="d-flex ms-2">
                    <button type="submit" class="btn btn-danger bg-transparent border-0 text-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-6">

            <h2 class="text-center">User Lists</h2>

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>PHOTO</th>
                        <th>ID</th>
                        <th>FIRSTNAME</th>
                        <th>LASTNAME</th>
                        <th>USERNAME</th>
                        <th>EDIT|DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user = $all_users->fetch_assoc()) {
                    ?>

                        <tr>
                            <!-- 5つのデータを横並びに表示 -->
                            <td>
                                <?php
                                //true->画像を表示
                                //false->fontawesomeを表示
                                if ($user['photo']) {
                                ?>
                                    <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto dashboard-photo">
                                <?php
                                } else {
                                ?>
                                    <i class="fa-solid fa-user text-seconary d-block text-center dashboard-icon"></i>
                                <?php
                                }
                                ?>
                            </td>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['first_name'] ?></td>
                            <td><?= $user['last_name'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td>
                                <?php
                                //true->Edit/Delete ボタンを表示
                                if ($_SESSION['id'] == $user['id']) {
                                ?>
                                    <a href="edit-user.php" class="btn btn-warning" title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>