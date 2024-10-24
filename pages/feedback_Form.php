<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Мой Не Сам-Форма</title>
   <!--<link rel="stylesheet" href="../styles/stiles_for_Main.css">-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header">
    </header>
    <main>
        <h1 class="noViolationsM2">Мой Не Сам</h1>
        <h1 class="noViolationsS">Заказ</h1>
        <form id="form" method="post" action="">
            <div class="contBlur"><input type="text" name="num" id="num" placeholder="Номер телефона" required>
                <div class="blurS"></div>
            </div>
          
            <select id="mark" name="mark" onchange="document.getElementById('textInput').style.display = this.value === 'other' ? 'block' : 'none';" class="contBlur">
            <option value="" disabled selected>Выберите услугу</option>
  <option value="клининг">общий клининг</option>
  <option value="генеральная уборка">генеральная уборка</option>
  <option value="послестроительная уборка">послестроительная уборка</option>
  <option value="химчистка">химчистка ковров и мебели</option>
  <option value="other" id="other">другое</option>
    <input type="text" id="textInput" name="markother"style="display:none;" placeholder="Введите услугу"/>
</select>

                <div class="blurS"></div>
            </div>
            <select id="nar" name="nar" class="contBlur">
            <option value="" disabled selected>Выберите метод оплаты</option>
  <option value="наличка">наличными</option>
  <option value="карточкой">картой</option>
</select>
<div class="contBlur">
                <div class="inline-b" style="display: none">
                    <input type="file" name="file" id="file" accept=".jpg, .jpeg, .png" multiple>
                    <label for="file" class="file">+</label>
                    <span class="file-text"> файл</span>
                </div>

                <div class="blurS"></div>
            </div>
            <div class="contBlur">
                <div class="blurS"></div>
            </div>
            <div class="contBlur"><input type="text" name="local" id="local" placeholder="Место" required>
                <div class="blurS"></div>
            </div>
            <div class="contBlur"><input type="submit" value="Отправить">
                <div class="blur"></div>
            </div>
        </form>
        <section id="links">
            <a class="reg" href="./about_Us.php">
                <h2 class="text t2">Связаться с нами</h2><img class="str" src="../Additional_Files/Images/str.png"
                    alt="">
                <div class="blur"></div>
            </a>
            <a class="reg" href="<?php echo '../main.php?id='.$_GET['id'] ?>">
                <h2 class="text t2">Вернуться</h2><img class="str" src="../Additional_Files/Images/str.png" alt="">
                <div class="blur"></div>
            </a>
        </section>
        <section id="err"></section>
    </main>
    <footer></footer>
</body>




<script>

    array = ['num', 'mark', 'nar', 'local'];
    mass = ['Номер телефона', 'Услуга', 'Оплата', 'Место']
    pattern = [/^[a-zA-Z0-9А-Яа-я\s]{0,50}[^!@#$%\^&*()_+=-?:;№\|\/\\>]$/m,
        /^[a-zA-Z0-9А-Яа-я\s]{0,50}[^!@#$%\^&*()_+=-?:;№\|\/\\>]$/m,
        /^[a-zA-Z0-9А-Яа-я\s]{0,50}[^!@#$%\^&*()_+=-?:;№\|\/\\>]$/m,
        /^[a-zA-Z0-9А-Яа-я\s]{0,50}[^!@#$%\^&*()_+=-?:;№\|\/\\>]$/m,
    ];
    form.addEventListener('submit', function (event) {
        let flag = true;
        if (document.querySelector('.blurSErr')) {
            document.querySelector('.blurSErr').classList.add('blurS')
            document.querySelector('.blurSErr').classList.remove('blurSErr')
        }
        let indexCount = 0;
        array.forEach(element => {
            if (!flag)
                return;
            console.log(`${pattern[indexCount]}` + ' ' + `${document.getElementById(element).value}` + ' = ')
            console.log(pattern[indexCount].test(`${document.getElementById(element).value}`));
            if (!pattern[indexCount].test(`${document.getElementById(element).value}`)) {
                // console.log(element)
                flag = false;
                let massage = '';
                document.getElementById(element).parentElement.querySelector('.blurS').classList.add('blurSErr')
                document.getElementById(element).parentElement.querySelector('.blurS').classList.remove('blurS')
                document.getElementById('err').innerHTML = `<div class="contBlur"><h3 class="err">Ошибка: Поле ${mass[indexCount]} ${massage}</h3><div class="blurSErr"></div></div>`;
                indexCount++;
                return false;
            }
            indexCount++;
        });
        if (flag === false)
            event.preventDefault();
    });
</script>
<script type='text/javascript'>
     $(function (){
    $("#mark").change(function(){
        var o=$("#textInput");
        if (this.value=='other') {
            o.show();
        } else {
            o.hide();
        };
    });
});
</script>
</html>
<?php
if (isset($_POST["num"]) && isset($_POST["mark"]) && isset($_POST["nar"]) && isset($_POST['local'])) {
   
    $variable = [$_POST["num"], $_POST["mark"], $_POST["nar"], $_POST['local']];
    $variablePatterns = [
             '/^[a-zA-Z0-9]{3,255}/',
            '/^[a-zA-Z0-9А-Яа-я\s]{0,255}/',
            '/^[a-zA-Z0-9А-Яа-я\s]{5,255}/',
            '/^[a-zA-Z0-9А-Яа-я\s]{5,255}/'
    ];
    $i = 0;
    $flag = true;
    foreach ($variable as $key) {
        if ($key == '' || !preg_match($variablePatterns[$i], $key)) {
            $flag = false;
            echo "<h3 style='color: white;'>Данные занесены не верно</h3>";
            break;
        }
        $i += 1;
    }
    if ($flag) {
        require("../remote/pd.php");
          $user = $_GET['id'];
        if ($_POST['mark']=='other') {
            $other_service = $pdo->quote($_POST['markother']);
            $query = "insert into bid_pr (`Cornumber`, `Description`, `Status`, `User_id`, `image`,`Mark`,`location`,`date`,`time`) values ('" . $_POST["num"] . "', '" . $_POST["nar"] . "', 'На рассмотрении' , '$user' , '' ,$other_service, '" . $_POST["local"] . "', '".date('d/m/Y')."' , '".date('H:i:s', time())."')";
        echo $query;
        }
        if ($_POST['mark']!=='other'){
        $query = "insert into bid_pr (`Cornumber`, `Description`, `Status`, `User_id`, `image`,`Mark`,`location`,`date`,`time`) values ('" . $_POST["num"] . "', '" . $_POST["nar"] . "', 'На рассмотрении' , '$user' , '' ,'" . $_POST["mark"] . "', '" . $_POST["local"] . "', '".date('d/m/Y')."' , '".date('H:i:s', time())."')";
         }
        $result = $pdo->query($query);
        
        ?>
        <script>alert('Ваша заявка принята.')</script>
        <?php
        if ($result !== false) {
            ?>
            <script>
                window.location = '<?php echo '../main.php?id='.$_GET['id']; ?>';
            </script>
            <?php
            exit;
            }
            
        
    }
}
?>
