document.addEventListener("DOMContentLoaded", () => {
    const messageInput = document.getElementById("message");
    const fontColorInput = document.getElementById("fontColor");
    const fontSizeInput = document.getElementById("fontSize");
    const fontSizeValue = document.getElementById("fontSizeValue");
    const backgroundInput = document.getElementById("background");
    const ecardMessage = document.getElementById("ecardMessage");
    const ecardCanvas = document.getElementById("ecardCanvas");
    const generateButton = document.getElementById("generateEcard");
    const downloadButton = document.getElementById("downloadEcard");

    // Update preview on customization changes
    messageInput.addEventListener("input", () => {
        ecardMessage.textContent = messageInput.value || "Your message will appear here";
    });

    fontColorInput.addEventListener("input", () => {
        ecardMessage.style.color = fontColorInput.value;
    });

    fontSizeInput.addEventListener("input", () => {
        ecardMessage.style.fontSize = `${fontSizeInput.value}px`;
        fontSizeValue.textContent = `${fontSizeInput.value}px`;
    });

    backgroundInput.addEventListener("change", () => {
        ecardCanvas.style.backgroundImage = `url('${backgroundInput.value}')`;
    });

    // Generate button functionality
    generateButton.addEventListener("click", () => {
        alert("Your e-card is ready! You can now download it.");
        downloadButton.disabled = false; // Enable the download button
    });

    // Download E-Card as image
    downloadButton.addEventListener("click", () => {
        html2canvas(ecardCanvas).then((canvas) => {
            const link = document.createElement("a");
            link.download = "ecard.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    });
});