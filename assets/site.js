function phInitMobileMenu() {
  const toggle = document.getElementById("menu-toggle");
  const menu = document.getElementById("mobile-menu");
  if (!toggle || !menu) return;

  toggle.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
}

function phInitChat() {
  const openBtn = document.querySelector("[data-ph-chat-open]");
  const closeBtn = document.querySelector("[data-ph-chat-close]");
  const form = document.querySelector("[data-ph-chat-form]");
  const input = document.querySelector("[data-ph-chat-input]");
  const messages = document.querySelector("[data-ph-chat-messages]");
  const endpoint = form?.getAttribute("data-endpoint") || "chat.php";

  if (!openBtn || !closeBtn || !form || !input || !messages) return;

  function addBubble(text, who) {
    const div = document.createElement("div");
    div.className =
      "ph-chat-bubble " + (who === "user" ? "ph-chat-bubble--user" : "ph-chat-bubble--bot");
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
  }

  function addLoader() {
    const loader = document.createElement("div");
    loader.className = "ph-chat-loader";
    loader.setAttribute("data-ph-chat-loader", "1");
    messages.appendChild(loader);
    messages.scrollTop = messages.scrollHeight;
  }

  function removeLoader() {
    const loader = messages.querySelector("[data-ph-chat-loader]");
    if (loader) loader.remove();
  }

  function open() {
    document.body.classList.add("chat-open");
    setTimeout(() => input.focus(), 0);
  }

  function close() {
    document.body.classList.remove("chat-open");
  }

  openBtn.addEventListener("click", open);
  closeBtn.addEventListener("click", close);

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const text = String(input.value || "").trim();
    if (!text) return;

    input.value = "";
    addBubble(text, "user");

    const submitBtn = form.querySelector("button[type='submit']");
    if (submitBtn) submitBtn.disabled = true;
    addLoader();

    try {
      const res = await fetch(endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text }),
      });
      const data = await res.json().catch(() => null);
      const reply = data?.reply ? String(data.reply) : "Sorry — I couldn’t generate a reply.";
      removeLoader();
      addBubble(reply, "bot");
    } catch {
      removeLoader();
      addBubble("The message could not be sent. Please try again.", "bot");
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  phInitMobileMenu();
  phInitChat();
});

