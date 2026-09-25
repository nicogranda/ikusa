<br><br><br><br><br><br><br><br><br><br><br><br>
<h2 style="color:black;">Chat con Ikusa Bot</h2>

<div id="chat" style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:auto;"></div>

<input id="msg" type="text" placeholder="Escribe aquí..." style="width:80%;">
<button onclick="send()">Enviar</button>

<script>
function send(){
  let input = document.getElementById("msg");
  let message = input.value;
  if(message.trim() === "") return;

  fetch("/index.php?page=chat&action=send", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"   // ✅ JSON
    },
    body: JSON.stringify({ message: message })  // ✅ clave correcta
  })
  .then(r => r.json())                          // ✅ parsear JSON
  .then(res => {
    let chat = document.getElementById("chat");
    chat.innerHTML += `<p><b>Tú:</b> ${message}</p>`;
    chat.innerHTML += `<p><b>Bot:</b> ${res.response}</p>`;  // ✅ res.response
    chat.scrollTop = chat.scrollHeight;
    input.value = "";
  })
  .catch(err => console.error("Error:", err));
}
</script>
