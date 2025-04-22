<?php
// Array of quotes
$quotes = [
    ["quote" => "The best way to predict the future is to invent it.", "author" => "Alan Kay"],
    ["quote" => "Life is what happens when you're busy making other plans.", "author" => "John Lennon"],
    ["quote" => "The only limit to our realization of tomorrow is our doubts of today.", "author" => "Franklin D. Roosevelt"],
    ["quote" => "Do not watch the clock. Do what it does. Keep going.", "author" => "Sam Levenson"],
    ["quote" => "The harder you work for something, the greater you’ll feel when you achieve it.", "author" => "Unknown"],
    ["quote" => "Don’t stop when you’re tired. Stop when you’re done.", "author" => "Marilyn Monroe"],
    ["quote" => "Success is not the key to happiness. Happiness is the key to success.", "author" => "Albert Schweitzer"]
];

// Get a random quote
$randomIndex = array_rand($quotes);
$randomQuote = $quotes[$randomIndex];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Quote Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="quote-box">
        <p class="quote">"<?php echo htmlspecialchars($randomQuote['quote']); ?>"</p>
        <p class="author">- <?php echo htmlspecialchars($randomQuote['author']); ?></p>
    </div>
    <button class="refresh-btn" onclick="window.location.reload();">New Quote</button>
</div>
</body>
</html>