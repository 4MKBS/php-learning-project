document.addEventListener("DOMContentLoaded", () => {
    const uploadArea = document.getElementById("uploadArea");
    const fileInput = document.getElementById("fileInput");
    const progressBar = document.getElementById("progressBar");
    const progressContainer = document.getElementById("progressContainer");

    // Open file dialog on click
    uploadArea.addEventListener("click", () => fileInput.click());

    // Drag and drop events
    uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.classList.add("dragover");
    });

    uploadArea.addEventListener("dragleave", () => uploadArea.classList.remove("dragover"));

    uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.classList.remove("dragover");
        handleFiles(e.dataTransfer.files);
    });

    fileInput.addEventListener("change", () => handleFiles(fileInput.files));

    function handleFiles(files) {
        [...files].forEach(uploadFile);
    }

    function uploadFile(file) {
        const formData = new FormData();
        formData.append("file", file);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "upload.php", true);

        // Show progress container
        progressContainer.style.display = "block";

        xhr.upload.onprogress = function (e) {
            const percentComplete = (e.loaded / e.total) * 110;
            progressBar.style.width = `${percentComplete}%`; // Update the width of the bar
        };

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    setTimeout(() => {
                        progressBar.style.width = "0%"; // Reset progress bar
                        progressContainer.style.display = "none"; // Hide progress container
                        window.location.reload(); // Reload the page to show uploaded files
                    }, 1000);
                } else {
                    alert(response.message);
                }
            }
        };

        xhr.send(formData);
    }
});