<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Card Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>E-Card Generator</h1>
    <p>Create your personalized e-card by customizing the options below!</p>
    <div class="generator">
        <div class="customization-panel">
            <form id="ecardForm">
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" rows="4" placeholder="Enter your message"></textarea>
                </div>
                <div class="form-group">
                    <label for="fontColor">Font Color</label>
                    <input type="color" id="fontColor" value="#000000">
                </div>
                <div class="form-group">
                    <label for="fontSize">Font Size</label>
                    <input type="range" id="fontSize" min="14" max="48" value="24">
                    <span id="fontSizeValue">24px</span>
                </div>
                <div class="form-group">
                    <label for="background">Background Image</label>
                    <select id="background">
                        <option value="">Select Background</option>
                        <option value="./background/bg1.jpg">Background 1</option>
                        <option value="./background/bg2.jpg">Background 2</option>
                        <option value="./background/bg3.jpg">Background 3</option>
                    </select>
                </div>
                <button type="button" id="generateEcard">Generate E-Card</button>
            </form>
        </div>
        <div class="ecard-preview" id="ecardPreview">
            <div id="ecardCanvas" class="ecard">
                <p id="ecardMessage">Your message will appear here</p>
            </div>
        </div>
    </div>
    <button id="downloadEcard" class="download-btn">Download E-Card</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="script.js"></script>
</body>
</html>