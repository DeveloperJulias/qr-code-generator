<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced AI Text Generator</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #4cc9f0;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --gray: #e9ecef;
            --dark-gray: #495057;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-gray);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 30px;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        textarea {
            width: 100%;
            min-height: 250px;
            padding: 15px;
            font-size: 16px;
            border: 1px solid var(--gray);
            border-radius: var(--border-radius);
            resize: vertical;
            transition: border-color 0.3s;
            box-sizing: border-box;
            font-family: var(--font-family);
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.3s, transform 0.1s;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        #clearBtn {
            background-color: var(--dark-gray);
        }

        #clearBtn:hover {
            background-color: #343a40;
        }

        .prompt-container {
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 20px;
            display: none;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .prompt-container input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid var(--gray);
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .prompt-container input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }

        .loading {
            display: none;
            margin-top: 20px;
            text-align: center;
            animation: fadeIn 0.3s;
        }

        .spinner {
            display: inline-block;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary-color);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: var(--border-radius);
            display: none;
            animation: fadeIn 0.3s;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .character-count {
            text-align: right;
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-top: 8px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .settings {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .setting-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .setting-item label {
            margin-bottom: 0;
            font-weight: normal;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .buttons {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Enhanced AI Text Generator</h1>
        <p class="subtitle">Get AI-powered assistance with your writing</p>

        <div class="form-group">
            <label for="userText">Enter or edit your text:</label>
            <textarea id="userText" placeholder="Start typing or use AI to generate text..."></textarea>
            <div class="character-count"><span id="charCount">0</span> characters</div>
        </div>

        <div class="settings">
            <div class="setting-item">
                <input type="checkbox" id="appendText" checked>
                <label for="appendText">Append AI text at cursor</label>
            </div>
            <div class="setting-item">
                <label for="maxTokens">Max length:</label>
                <select id="maxTokens">
                    <option value="50">Short</option>
                    <option value="100" selected>Medium</option>
                    <option value="200">Long</option>
                    <option value="300">Very Long</option>
                </select>
            </div>
        </div>

        <div class="buttons">
            <button id="generateBtn">
                <i class="fas fa-robot"></i> Generate with AI
            </button>
            <button id="clearBtn">
                <i class="fas fa-trash-alt"></i> Clear
            </button>
        </div>

        <div id="statusMessage" class="status-message"></div>

        <div id="promptContainer" class="prompt-container">
            <label for="promptInput">What would you like the AI to write about?</label>
            <input type="text" id="promptInput" placeholder="E.g., Write a paragraph about space exploration">
            <button id="submitPromptBtn">
                <i class="fas fa-paper-plane"></i> Submit
            </button>
        </div>

        <div id="loading" class="loading">
            <div class="spinner"></div>
            <span>Generating text... Please wait.</span>
        </div>

        <footer>
            Powered by OpenAI's API • Use responsibly
        </footer>
    </div>

    <script>
        // Get references to DOM elements
        const textarea = document.getElementById('userText');
        const charCount = document.getElementById('charCount');
        const generateBtn = document.getElementById('generateBtn');
        const clearBtn = document.getElementById('clearBtn');
        const promptContainer = document.getElementById('promptContainer');
        const promptInput = document.getElementById('promptInput');
        const submitPromptBtn = document.getElementById('submitPromptBtn');
        const loading = document.getElementById('loading');
        const statusMessage = document.getElementById('statusMessage');
        const appendText = document.getElementById('appendText');
        const maxTokens = document.getElementById('maxTokens');

        const API_KEY = 'AIzaSyC24Mc9y5Vd26NUMz6r9LLxcYUOMcXgOpY'; // Replace with your Gemini API key

        // Update character count
        function updateCharCount() {
            charCount.textContent = textarea.value.length;
        }

        // Initialize character count
        updateCharCount();

        // Add event listener for textarea input
        textarea.addEventListener('input', updateCharCount);

        // Generate button click handler
        generateBtn.addEventListener('click', () => {
            promptContainer.style.display = 'block';
            promptInput.focus();
        });

        // Clear button click handler
        clearBtn.addEventListener('click', () => {
            textarea.value = '';
            updateCharCount();
            showStatusMessage('Text cleared', 'success');
        });

        async function fetchGeminiResponse(prompt) {
            // Get the max tokens setting
            const maxTokensValue = parseInt(maxTokens.value);

            try {
                const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=${API_KEY}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        contents: [{
                            parts: [{
                                text: prompt
                            }]
                        }],
                        generationConfig: {
                            maxOutputTokens: maxTokensValue
                        }
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error?.message || 'Failed to fetch AI response');
                }

                return data.candidates[0]?.content?.parts[0]?.text || 'No response received';
            } catch (error) {
                throw error;
            }
        }

        submitPromptBtn.addEventListener('click', async () => {
            const prompt = promptInput.value.trim();
            if (!prompt) {
                showStatusMessage('Please enter a prompt', 'error');
                return;
            }

            loading.style.display = 'block';
            statusMessage.style.display = 'none';
            promptContainer.style.display = 'none';

            try {
                const aiResponse = await fetchGeminiResponse(prompt);

                if (appendText.checked && textarea.selectionStart !== undefined) {
                    // Get cursor position
                    const startPos = textarea.selectionStart;
                    const endPos = textarea.selectionEnd;

                    // Get text before and after cursor
                    const textBefore = textarea.value.substring(0, startPos);
                    const textAfter = textarea.value.substring(endPos);

                    // Insert AI response at cursor position
                    textarea.value = textBefore + aiResponse + textAfter;

                    // Place cursor after inserted text
                    textarea.selectionStart = startPos + aiResponse.length;
                    textarea.selectionEnd = startPos + aiResponse.length;
                } else {
                    // Replace text
                    textarea.value = aiResponse;
                }

                updateCharCount();
                showStatusMessage('Text generated successfully!', 'success');
            } catch (error) {
                showStatusMessage(`Error: ${error.message}`, 'error');
            } finally {
                loading.style.display = 'none';
            }
        });

        function showStatusMessage(message, type) {
            statusMessage.textContent = message;
            statusMessage.className = 'status-message ' + type;
            statusMessage.style.display = 'block';

            // Hide after 3 seconds
            setTimeout(() => {
                statusMessage.style.display = 'none';
            }, 3000);
        }
    </script>
</body>

</html>