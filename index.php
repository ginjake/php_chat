<html>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>
<?php 
if (empty($_POST["room"])) {
  $room = "room1";
} else {
  $room = $_POST["room"];
}
?>
var conn = new WebSocket('ws://128.199.246.253:8080?<?php echo($room)?>');

//接続できた
conn.onopen = function(e) {
    console.log(e);
};
 
 //メッセージを受け取った
conn.onmessage = function(e) {
    console.log(e.data);
    var receive_data = {}
    receive_data = JSON.parse(e.data)
    append_message = "<div>"+receive_data["name"] + ":" + receive_data["message"] + "<div>"
    $("#message_box").append(append_message);
};

conn.onerror = function(e) {
    alert("エラー");
};

//接続が切れた
conn.onclose = function(e) {
    alert("接続がきれました");
};

//メッセージを送る
function send() {
  var param = {}
  param["name"] = $('#name').val();
  param["message"] = $('#message').val();
  conn.send(JSON.stringify(param));
}
</script>
<body>
  <div style="background-color:#FFAAFF">
    現在はルーム<?php echo($room);?>に入室中です
    <form action="index.php" method="post">
      <select name="room">
        <option value="room1">ROOM1</option>
        <option value="room2">ROOM2</option>
        <option value="room3">ROOM3</option>
      </select>
      <input type="submit" value="移動"/>
    </form>
  </div>
  
  <div style="background-color:#FFFFAA">
    名前<input type="text" id="name"> <br>
    メッセージ<input type="text" id="message"> <br>
    <input type="button" value="送信" onclick="send()">
  </div>
  
  <div id="message_box" style="background-color:#AAFFFF">
    
  </div>
</body>
</html>