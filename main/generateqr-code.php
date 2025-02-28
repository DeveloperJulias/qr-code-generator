<!-- 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["text"])) {
    $text = $_POST["text"];

    // Create a new QR code instance
    $qrCode = new QrCode($text);

    // Create a new PNG writer instance
    $writer = new PngWriter();

    // Generate the QR code image
    $result = $writer->write($qrCode);

    // Set the content type header to PNG
    header('Content-Type: ' . $result->getMimeType());

    // Output the QR code image
    echo $result->getString();
    exit;
} -->
