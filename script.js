function handleKeyPress(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
}

async function sendMessage() {
    let inputField = document.getElementById("user-input");
    let userMessage = inputField.value.trim();
    
    if (userMessage === "") return;
    
    let chatBody = document.getElementById("chat-body");
    chatBody.innerHTML += `<div><strong>You:</strong> ${userMessage}</div>`;
    inputField.value = "";

    let userLang = await detectLanguage(userMessage);

    let response = await fetch("chatbot.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: userMessage, lang: userLang })
    });

    let data = await response.json();
    chatBody.innerHTML += `<div><strong>Bot:</strong> ${data.reply}</div>`;
    chatBody.scrollTop = chatBody.scrollHeight;
}
