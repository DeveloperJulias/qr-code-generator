<?php
require './vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;

$image_qrCode = '';

if (isset($_POST['generate'])) {
    if (!empty(trim($_POST['text']))) {
        $temporary_directory = 'temp/';
        $file_name = md5(uniqid()) . '.png';
        $file_path = $temporary_directory . $file_name;

        // Ensure the temporary directory exists
        if (!is_dir($temporary_directory)) {
            mkdir($temporary_directory, 0755, true);
        }

        // Define colors
        $foregroundColor = new Color(255, 255, 255); // RGB for foreground
        $backgroundColor = new Color(253, 2, 199);  // RGB for background

        // Create the QR code
        $builder = new Builder(
            writer: new PngWriter(),
            data: trim($_POST['text']),
            size: 300,
            foregroundColor: $foregroundColor,
            backgroundColor: $backgroundColor
        );

        $result = $builder->build();

        // Save the QR code to a file
        $result->saveToFile($file_path);

        // Prepare the image tag to display the QR code
        $image_qrCode = '<img src="' . $file_path . '" alt="Generated QR Code" class="h-64 w-64">';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #d946ef);
        }

        .card {
            backdrop-filter: blur(16px);
            background-color: rgba(255, 255, 255, 0.7);
            background-color: rgba(255, 255, 255, 0.7);
            /* background-color: rgba(253, 2, 199, 0.96); */
        }

        textarea {
            resize: vertical;
            min-height: 120px;
            width: 100%;
            border-radius: 0.375rem;
            border: 1px solid #D1D5DB;
            padding: 0.5rem 0.75rem;
            outline: none;
            transition: all 0.3s ease;
        }

        textarea:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>


<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="card rounded-xl shadow-2xl w-full max-w-3xl p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">QR Code Generator</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="grid md:grid-cols-2 gap-8">

                <!-- QR Code Preview -->
                <div class="flex flex-col items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                        <div id="qrcode" class="flex items-center justify-center h-64 w-64">
                            <?= $image_qrCode ?>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="space-y-4">
                    <div>
                        <label for="text" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="text" id="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter text or URL for your QR code"></textarea>
                    </div>

                    <button type="submit" name="generate" value="1" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 mt-6">
                        Generate QR Code
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>