<html>

<body>
  <div style="background-color:#FFAAFF">
    ルームに入室
    <form action="room.php" method="post">
      <select name="room">
        <option value="room1">ROOM1</option>
        <option value="room2">ROOM2</option>
        <option value="room3">ROOM3</option>
      </select>
      <input type="submit" value="移動"/>
    </form>
  </div>
  
  
  <div style="background-color:#FFAAFF">
    個人チャット
    <form action="private.php" method="post">
      自分の名前<input type="text" name="name"> <br>
      相手の名前<input type="text" name="target"> <br>
      <input type="submit" value="移動"/>
    </form>
  </div>

</body>
</html>