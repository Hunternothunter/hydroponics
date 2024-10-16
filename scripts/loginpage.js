document.addEventListener('DOMContentLoaded', function () {
    const cstaTextElement = document.getElementById('csta-text');
    const dynamicTextElement = document.getElementById('dynamic-text');

    // Display CSTA text without animation
    cstaTextElement.innerText = 'Colegio de Sta. Teresa de Avila';

    // Animate dynamic text
    animateDynamicText(dynamicTextElement);
    showPassword();
});

async function animateDynamicText(element) {
    const phrases = ["#Education That Transcends", "#TaraNaSaTERESA"];
    let index = 0;

    while (true) {

        if (index === 1 || index === 0) {
            await sleep(500);
        }

        await typeAndDelete(element, phrases[index]);
        index = (index + 1) % phrases.length;
    }
}

async function typeAndDelete(element, text) {
    // Type
    for (let i = 0; i < text.length; i++) {
        element.innerText = text.substring(0, i + 1);
        await sleep(50); // Adjust typing speed here
    }

    await sleep(1000); // Wait for a second before deleting

    // Delete
    for (let i = text.length; i > 0; i--) {
        element.innerText = text.substring(0, i);
        await sleep(50); // Adjust deleting speed here
    }
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
function showPassword() {
    const passwordInput = document.getElementById("password");
    const togglePasswordButton = document.getElementById("togglePassword");

    togglePasswordButton.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        // Toggle eye icon
        togglePasswordButton.innerHTML = type === "password" ? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';
    });
}