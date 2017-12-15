<html>
<?php 
if (empty($_POST["name"])) {
  echo("自分の名前が空です");
  echo("<a href='index.php'>戻る</a>");
  exit();
}
if (empty($_POST["target"])) {
  echo("相手の名前が空です");
  echo("<a href='index.php'>戻る</a>");
  exit();
}
 ?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>
<?php 

$myself = $_POST["name"];
$target = $_POST["target"];
$send_param["mode"] = "private";
$send_param["myself"] = $myself;
$send_param["target"] = $target;

?>
var conn = new WebSocket('ws://128.199.246.253:8080?<?php echo(http_build_query($send_param))?>');
var multi_login_count = 0//多重ログインのとき、相手の接続数をカウントする
//接続できた
conn.onopen = function(e) {
    console.log(e);
};
conn.onerror = function(e) {
    alert("エラー");
};
//接続が切れた
conn.onclose = function(e) {
    alert("接続がきれました");
};
 //メッセージを受け取った
conn.onmessage = function(e) {
    console.log(e.data);
    var receive_data = {}
    receive_data = JSON.parse(e.data)
    if (receive_data["type"] == "info") {
        if(receive_data["status"] == 'online') {
            multi_login_count++
            $("#login_state").text("【オンライン】");
        }
        if(receive_data["status"] == 'offline') {
            multi_login_count += -1;
            if (multi_login_count == 0) { //多重ログインのとき、1つでもコネクションが生きていればオンライン扱いにする
                $("#login_state").text("【オフライン】");
            }
        }
    } else if(receive_data["type"] == 'error') {
        append_message = "<div class='receive_error' style='color:#992222;'>相手がオフラインのため送信に失敗しました</div>"
        $("#message_box").append(append_message);
    
    } else {
        //チャット欄にメッセージ追加
        append_message = "<div class='receive_message'> "+receive_data["name"] +":" + receive_data["message"] + "<div>"
        $("#message_box").append(append_message);
    }
};


//メッセージを送る
function send() {
  var param = {}
  param["name"] = '<?php echo($myself) ?>';
  param["message"] = $('#message').val();
  conn.send(JSON.stringify(param));
  //チャット欄にメッセージ追加
}
</script>
<body>
  <div style="background-color:#FFAAFF">
    自分の名前:<?php echo($myself);?><br>
    相手の名前:<?php echo($target);?><span id="login_state">【オフライン】</span><br>
  </div>
  
  <div style="background-color:#FFFFAA">
    メッセージ<input type="text" id="message"> <br>
    <input type="button" value="送信" onclick="send()">
  </div>
  
  <div id="message_box" style="background-color:#AAFFFF">
    
  </div>
</body>
</html>