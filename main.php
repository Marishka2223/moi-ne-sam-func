<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Мой Не Сам-Главная</title>
    <link rel="stylesheet" href="./styles/stiles_for_Main.css">
    <script src="./javaScript/Ways.js"></script>
    <script>let c = 0;</script>
</head>

<body>
    <header>
        <a href="main.html" class="noViolations">
            <h1 class="noViolations">Мой Не Сам</h1>
        </a>
        <button class="settings">
            <img src="./Additional_Files/Images/Dem_exam_pr-site-Narusheniy.net-settings.png" alt="">
        </button>
    </header>
    <main>
        <h1 style="text-align: center;">Поданые заявления</h1>
        <section id="massage">
            <div class="contS">
                <?php
                $i = 0;
                if (isset($_SESSION["id"])) {
                    $id = $_SESSION["id"];
                    require("./remote/pd.php");
                    $date = '';
                    $request = [0 => ''];
                    $sql = "select * FROM bid_pr where User_id=$id";
                    $result = $pdo->query($sql);
                    foreach ($result as $row) {
                        $i++;
                        $request[$id] = $row["Bid_id"];
                        if ($date != $row['date']) {
                            $date = $row['date'];
                            echo "<div class='contD'><h2 class='Etext'>" . str_replace('/', '.', $date) . "</h2></div>";
                        }
                        $r =  $row["Bid_id"];
                        echo "<a class='contBlur' href='./pages/rename.php?massage_id=$r&id=".$_GET['id']."'><h2 class='Etext'>$i</h2><h2 class='Etext'>" . $row["time"] . "</h2><h2 class='Etext' style='position: absolute;right: 5px;'>" . $row["Status"] . "</h2><div class='blur'></div></a>";
                        $r = '';
                    }
                }
                ?>
                <!-- <script defer>
                    function log(r) {
                        // $.ajax({
                        //     type: "POST",
                        //     url: 'script.php',
                        //     cache: false,
                        //     data: {
                        //         'args': [
                        //             arg_1: r
                        //         ],
                        //         'func': "send"
                        //     },
                        //     dataType: 'json'
                        // });
                        alert('post');
                        fetch("./remote/scr.php", {
                            method: "POST", 
                            redirect: 'follow',
                            body: new URLSearchParams({
                                data: r
                            }),
                            headers: { "content-type": "application/x-www-form-urlencoded" }
                        }).then((response) => {
                            if (response.status !== 200) {
                                return Promise.reject();
                            }
                            return response.text()
                        })
                            .then(i => request.innerHTML = i )
                            .catch(() => console.log('ошибка '));
                        //     fetch("ajax_quest.php", {
                        //         method: "POST",
                        //         body: data_body,
                        //         headers: { "content-type": "application/x-www-form-urlencoded" }
                        //     })

                        //         .then((response) => {
                        //             if (response.status !== 200) {
                        //                 return Promise.reject();
                        //             }
                        //             return response.text()
                        //         })
                        //         .then(i => console.log(i))
                        //         .catch(() => console.log('ошибка'));
                        // }
                    }
                </script> -->
                <!-- Сделать страницу изменения запроса у пользователя -->
            </div>
        </section>
        <div id="request"></div>
        <section id="links">
            <a class="newMassage" href="<?php echo "./pages/feedback_Form.php?id=".$_GET['id']  ?>">
                <h2 class="text">Новое заявление</h2>
                <div class="blur"></div>
            </a>
            <?php
            if (session_status() != PHP_SESSION_NONE && isset($_SESSION["prov"])) {
                if ($_SESSION["prov"] == true)
                    echo '<a class="contactUs" href="./pages/admin_Panel.php?id='.$_GET['id'].'"><h2 class="text">Панель администратора</h2><div class="blur"></div></a>';
            }
            ?>
            <a class="contactUs" href="./pages/about_Us.php">
                <h2 class="text">Связаться с нами</h2>
                <div class="blur"></div>
            </a>
            <a class="contactUs" href="./pages/logout.php">
                <h2 class="text">Выйти</h2>
                <div class="blur"></div>
            </a>
        </section>
    </main>
    <footer></footer>
</body>

</html>