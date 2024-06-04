<?php
session_start();
require_once '../backend/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Character Translator</title>
</head>

<body>
    <?php
    require ("./navbar.php")
        ?>
    <link rel="stylesheet" href="../css/trjmh.css">


    <div class="trjmhContainer">
        <h1>Character Translator</h1>

        <textarea id="inputText" placeholder="Enter text here...">'6' 9' th ch sh</textarea>

        <button class="btnA" id="switchButton" onclick="switchTranslationDirection()">Switch Translation
            Direction</button>

        <button class="btnA" id="translateButton" onclick="translateText()">Translate</button>
        <br>
        <textarea id="outputText" placeholder="Translated text will appear here..." readonly></textarea>
    </div>

    <script>
        var currentTranslationDirection = 'en-ar';

        function switchTranslationDirection() {
            var switchButton = document.getElementById('switchButton');
            if (currentTranslationDirection === 'en-ar') {
                currentTranslationDirection = 'ar-en';
                switchButton.innerHTML = 'Translate Arabic to English';
            } else {
                currentTranslationDirection = 'en-ar';
                switchButton.innerHTML = 'Translate English to Arabic';
            }
            document.getElementById('outputText').value = ''; // Clear output when switching direction
        }

        function translateText() {
            var inputText = document.getElementById('inputText').value;
            var outputText = '';

            var enToArTranslationMap = {
                '2': 'ى',
                '3': 'ع',
                '4': 'ذ',
                '5': 'خ',
                '6': 'ط',
                '7': 'ح',
                '8': 'ق',
                '9': 'ص',
                'a': 'ا',
                'b': 'ب',
                'c': 'س',
                'd': 'د',
                'e': 'ي',
                'f': 'ف',
                'g': 'ق',
                'h': 'ه',
                'i': 'ي',
                'j': 'ج',
                'k': 'ك',
                'l': 'ل',
                'm': 'م',
                'n': 'ن',
                'o': 'و',
                'p': 'ب',
                'q': 'ك',
                'r': 'ر',
                's': 'س',
                't': 'ت',
                'u': 'و',
                'v': 'ڤ',
                'w': 'و',
                'x': 'اكس',
                'y': 'ي',
                'z': 'ز',
                'sh': 'ش',
                'th': 'ث',
                "3'": 'غ',
                "6'": 'ض',
                "9'": 'ظ',

                // Add more mappings here...
            };

            var arToEnTranslationMap = {
                'ى': '2',
                'ع': '3',
                'ذ': '4',
                'خ': '5',
                'ط': '6',
                'ح': '7',
                'ق': '8',
                'ص': '9',
                'ا': 'a',
                'ب': 'b',
                'س': 'c',
                'د': 'd',
                'ي': 'e',
                'ف': 'f',
                'ق': 'g',
                'ه': 'h',
                'ي': 'i',
                'ج': 'j',
                'ك': 'k',
                'ل': 'l',
                'م': 'm',
                'ن': 'n',
                'و': 'o',
                // 'ب': 'p',
                // 'ك': 'q',
                'ر': 'r',
                'س': 's',
                'ت': 't',
                // 'و': 'u',
                'ڤ': 'v',
                // 'و': 'w',
                'اكس': 'x',
                'ي': 'y',
                'ز': 'z',
                'ش': 'sh',
                'ث': 'th',
                'ض': "6'",
                'ظ': "9'",
                // Add more mappings here...
            };

            if (currentTranslationDirection === 'en-ar') {
                // Translate from English to Arabic
                for (var i = 0; i < inputText.length; i++) {
                    var translatedChar = enToArTranslationMap[inputText.substring(i, i + 2)];
                    if (translatedChar) {
                        outputText += translatedChar;
                        i++; // Skip next character
                    } else {
                        translatedChar = enToArTranslationMap[inputText[i]];
                        if (translatedChar) {
                            outputText += translatedChar;
                        } else {
                            outputText += inputText[i];
                        }
                    }
                }
            } else if (currentTranslationDirection === 'ar-en') {
                // Translate from Arabic to English
                for (var i = 0; i < inputText.length; i++) {
                    var translatedChar = arToEnTranslationMap[inputText[i]];
                    if (translatedChar) {
                        outputText += translatedChar;
                    } else {
                        outputText += inputText[i];
                    }
                }
            }
            document.getElementById('outputText').value = outputText;
        }
    </script>
</body>

</html>