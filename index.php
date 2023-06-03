<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$folderPath = './tem4/';
$allowedExtensions = ['mp3', 'wav', 'flac'];

$configsPath = './configs/';
$configFiles = scandir($configsPath);
$configFiles = array_diff($configFiles, ['.', '..']); // Remove "." and ".." from the list

// Get all file names in the folder
$files = scandir($folderPath);

// Filter files by allowed extensions
$filteredFiles = array_filter($files, function ($file) use ($allowedExtensions) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return in_array($extension, $allowedExtensions);
});

echo "<h2>Dictation System designed by <a href='https://github.com/Weicheng783' target='__blank'>Weicheng</a>, collaborated with ChatGPT.</h2>";
echo "<h2>Version May 26, 2023 as a Special Gift. Revised June 3, 2023.</h2>";
echo "<h2>Personal Project: NO.230603</h2>";

// Handle audio file selection
if (isset($_POST['audioFile']) or !isset($_POST['audioFile'])) {
    if(isset($_POST['audioFile'])){
        $selectedFile = $_POST['audioFile'];
    }else{
        $selectedFile = "./Lesson 1.mp3";
    }

    // Display audio controls
    echo '<h2 id="selectedFileTitle">Audio File Using 正在练习: ' . $selectedFile . '</h2>';
    echo '<audio id="audioPlayer" controls style="width: 80%;">';
    echo '<source src="' . $folderPath . $selectedFile . '" type="audio/mpeg">';
    echo 'Your browser does not support the audio element.';
    echo '</audio>';
    echo "<div>";
        echo '<input type="text" id="startPosition" placeholder="Start Position (seconds)" style="font-size: large;">';
        echo '<input type="text" id="finishPosition" placeholder="Finish Position (seconds)" style="font-size: large;">';
        echo '<input type="text" id="wordInput" placeholder="Word" style="font-size: large;">';
        echo '<input type="text" id="meaningInput" placeholder="Meaning" style="font-size: large;">';
        echo '<button id="appendButton" style="font-size: large;">Append</button>';
    echo "</div>";
    echo "<div>";
        echo '<button id="playButton" style="font-size: large;">Play</button>';
        echo '<button id="convertButton" style="font-size: large;">Convert to JSON</button>';
        echo '<button id="ttsButton" style="font-size: large;">Upload for TTS Generation</button>';
    echo "</div>";

    echo '<textarea id="wordList" rows="10" cols="50" style="font-size: large;"></textarea>';
    echo '<textarea id="wordList_real" rows="10" cols="50" style="font-size: large;" ></textarea>';

    echo "<div>";
        echo '<button id="backward1Button" style="font-size: large;">Backward 1 sec</button>';
        echo '<button id="backward5Button" style="font-size: large;">Backward 5 sec</button>';
        echo '<button id="forward1Button" style="font-size: large;">Forward 1 sec</button>';
        echo '<button id="forward5Button" style="font-size: large;">Forward 5 sec</button>';
    echo "</div>";

    echo '<script>';
    echo 'var audio = document.getElementById("audioPlayer");';
    echo 'var spacePressed = false;';
    echo 'var selectedFileTitle = document.getElementById("selectedFileTitle");';
    echo 'var startPosition = document.getElementById("startPosition");';
    echo 'var finishPosition = document.getElementById("finishPosition");';
    echo 'var wordInput = document.getElementById("wordInput");';
    echo 'var meaningInput = document.getElementById("meaningInput");';
    echo 'var playButton = document.getElementById("playButton");';
    echo 'var appendButton = document.getElementById("appendButton");';
    echo 'var convertButton = document.getElementById("convertButton");';
    echo 'var wordList = document.getElementById("wordList");';
    echo 'var wordList_real = document.getElementById("wordList_real");';
    echo 'var wordData = [];';
    echo 'var wordData_real = [];';
    echo 'var backward1Button = document.getElementById("backward1Button");';
    echo 'var backward5Button = document.getElementById("backward5Button");';
    echo 'var forward1Button = document.getElementById("forward1Button");';
    echo 'var forward5Button = document.getElementById("forward5Button");';
    echo 'playButton.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  var start = parseFloat(startPosition.value);';
    echo '  var finish = parseFloat(finishPosition.value);';
    echo '  if (!isNaN(start) && !isNaN(finish)) {';
    echo '    audio.currentTime = start;';
    echo '    if (!audio.paused) {';
    echo '      audio.play();';
    echo '      setTimeout(function() {';
    echo '        audio.pause();';
    echo '      }, (finish - start) * 1000); console.log((finish - start) * 1000);';
    echo '      spacePressed = false;';
    echo '      console.log("Audio started.");';
    echo '    }';
    echo '  }';
    echo '});';
    echo 'appendButton.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  var start = parseFloat(startPosition.value);';
    echo '  var finish = parseFloat(finishPosition.value);';
    echo '  var word = wordInput.value.trim();';
    echo '  var meaning = meaningInput.value.trim();';
    echo '  if (start !== "" && finish !== "" && word !== "" && meaning !== "") {';
    echo '    var line = "Start: " + start + ", Finish: " + finish + ", Word: " + word + ", Meaning: " + meaning;';
    echo '    wordList_real.value += word + "\n";';
    echo '    wordList.value += line + "\n";';
    echo '    startPosition.value = "";';
    echo '    finishPosition.value = "";';
    echo '    wordInput.value = "";';
    echo '    meaningInput.value = "";';
    echo '    var wordEntry = {';
    echo '      start: start,';
    echo '      finish: finish,';
    echo '      word: word,';
    echo '      meaning: meaning';
    echo '    };';
    echo '    wordData.push(wordEntry); wordData_real.push(word);';
    echo '  }';
    echo '});';
    echo 'convertButton.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  var jsonData = JSON.stringify(wordData, null, 2);';
    echo '  var jsonOutput = document.createElement("pre");';
    echo '  jsonOutput.textContent = jsonData;';
    echo '  wordList.appendChild(jsonOutput);
            $.ajax({
                url: "store_config.php",
                type: "POST",
                data: { wordData: wordData },
                success: function(response) {
                    // Clear the wordData contents on success
                    wordData = null;
            
                    // Process the response if needed
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.log(error);
                }
            });';
    echo '});';

    echo 'ttsButton.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  var jsonData = JSON.stringify(wordData_real, null, 2);';
    echo '  var jsonOutput = document.createElement("pre");';
    echo '  jsonOutput.textContent = jsonData;';
    echo '  wordList_real.appendChild(jsonOutput);
            var jsonData = wordData_real;
            var blob = new Blob([jsonData], { type: "text/plain" });
            var formData = new FormData();
            formData.append("file", blob, "wordData_real.txt");

            $.ajax({
                url: "http://132.145.27.119:8026/voices/upload_words.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Clear the wordData contents on success
                    wordData_real = null;
            
                    // Process the response if needed
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.log(error);
                }
            });';
    echo '});';

    echo 'backward1Button.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  audio.currentTime -= 1;';
    echo '});';
    echo 'backward5Button.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  audio.currentTime -= 5;';
    echo '});';
    echo 'forward1Button.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  audio.currentTime += 1;';
    echo '});';
    echo 'forward5Button.addEventListener("click", function(event) {';
    echo '  event.preventDefault();'; // Prevent default form submission behavior
    echo '  audio.currentTime += 5;';
    echo '});';
    echo 'document.addEventListener("keydown", function(event) {';
    echo '  if (event.code === "Space") {';
    echo '    event.preventDefault();';
    echo '    if (startPosition.value === "") {';
    echo '      startPosition.value = audio.currentTime;';
    echo '    } else if (finishPosition.value === "") {';
    echo '      finishPosition.value = audio.currentTime;';
    echo '    }';
    echo '    if (spacePressed) {';
    echo '      audio.pause();';
    echo '      spacePressed = false;';
    echo '      console.log("Audio paused.");';
    echo '    } else {';
    echo '      audio.play();';
    echo '      spacePressed = true;';
    echo '      console.log("Audio started.");';
    echo '    }';
    echo '  }';
    echo '});';
    echo 'startPosition.addEventListener("keydown", function(event) {';
    echo '  event.stopPropagation();';
    echo '});';
    echo 'finishPosition.addEventListener("keydown", function(event) {';
    echo '  event.stopPropagation();';
    echo '});';
    echo 'wordInput.addEventListener("keydown", function(event) {';
    echo '  event.stopPropagation();';
    echo '});';
    echo 'meaningInput.addEventListener("keydown", function(event) {';
    echo '  event.stopPropagation();';
    echo '});';
    echo 'function updateAudioSource(selectedFile) {';
    echo '  selectedFileTitle.textContent = "Selected audio file: " + selectedFile;';
    echo '  var source = document.createElement("source");';
    echo '  source.src = "' . $folderPath . '" + selectedFile;';
    echo '  source.type = "audio/mpeg";';
    echo '  audio.innerHTML = "";';
    echo '  audio.appendChild(source);';
    echo '}';
    echo 'updateAudioSource("' . $selectedFile . '");'; // Update audio source initially
    echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = json_decode(file_get_contents('php://input'), true);
    if ($jsonData !== null) {
      // Update the configContent with the received JSON data
      $configContent = json_encode($jsonData, JSON_PRETTY_PRINT);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dictation System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div><input type="checkbox" id="myCheckbox" style="font-size: large;">Developer Debugging Mode 开发者调试模式</input></div>
<div><input type="checkbox" id="myCheckbox1" style="font-size: large;" checked>Text-to-Speech 文字转语音模式</input></div>

<body style="text-align: center; background-color: #ADD8E6;">
    <h2 id="listening_files" hidden>Select an audio file 选你要练习的听力文件: (TTS模式可不用)</h2>
    <form method="post" onsubmit="event.preventDefault();">
        <select name="audioFile" id="audioFileSelector" style="font-size: large;" hidden>
            <option value="">Choose...</option>
            <?php foreach ($filteredFiles as $file): ?>
                <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" value="Play" hidden>
    </form>

    <h2>Select a config (data) file 选听力对应的数据文件:</h2>
    <form id="configForm" onsubmit="event.preventDefault();">
    <select name="configFile" id="configFileSelector" style="font-size: large;">
        <?php foreach ($configFiles as $file): ?>
        <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <div>
        <textarea id="configContent_li" rows="10" cols="50" readonly style="font-size: large;"></textarea>
        <textarea id="configContent_ready_li" rows="10" cols="50" readonly style="font-size: large;"></textarea>
    </div>

    <div>
        <textarea id="configContent" rows="10" cols="50" readonly style="font-size: large;"></textarea>
        <textarea id="configContent_ready" rows="10" cols="50" readonly style="font-size: large;"></textarea>
    </div>

    <label style="font-size: large;" for="numWordsInput">Number of Words 总共报多少词:</label>
    <input style="font-size: large;" type="number" id="numWordsInput" min="1" step="1">
    <label style="font-size: large;" for="repeatTimesInput">Repeat Times 每词重复多少遍:</label>
    <input style="font-size: large;" type="number" id="repeatTimesInput" min="1" step="1">
    <label style="font-size: large;" for="pauseTimeInput">Pause Time (in seconds) 词与词之间播报间隔秒数(可小数):</label>
    <input style="font-size: large;" type="number" id="pauseTimeInput" min="0" step="0.1">

    <div>
        <button style="font-size: large;" type="submit" id="shuffleStartButton">Shuffle Start 乱序开始</button>
        <button style="font-size: large;" type="submit" id="startInOrderButton">Start in Order 顺序开始</button>
    </div>

    <audio id="beginPlayer">
        <source src="begin.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <audio id="endPlayer">
        <source src="end.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <audio id="ShufflePlayer">
        <source src="Shuffle.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <audio id="MoondropPlayer">
        <source src="Moondrop.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>


    </form>

    <script>
        var checkbox1 = document.getElementById("myCheckbox1");
        checkbox1.addEventListener('change', function() {
            if(!this.checked){
                document.getElementById("listening_files").style.display = "initial";
                document.getElementById("audioFileSelector").style.display = "initial";
            }else{
                document.getElementById("listening_files").style.display = "none";
                document.getElementById("audioFileSelector").style.display = "none";
            }
        });

        var checkbox = document.getElementById('myCheckbox');
        checkbox.addEventListener('change', function() {
            if (!this.checked) {
                document.getElementById("startPosition").style.display = 'none';
                document.getElementById("finishPosition").style.display = 'none';
                document.getElementById("wordInput").style.display = 'none';
                document.getElementById("wordList").style.display = 'none';
                document.getElementById("meaningInput").style.display = 'none';
                document.getElementById("configContent").style.display = 'none';
                document.getElementById("configContent_ready").style.display = 'none';
                document.getElementById("playButton").style.display = 'none';
                document.getElementById("convertButton").style.display = 'none';
                document.getElementById("appendButton").style.display = 'none';
                document.getElementById("ttsButton").style.display = 'none';
                document.getElementById("wordList_real").style.display = 'none';
                document.getElementById("audioPlayer").style.display = 'none';
                document.getElementById("backward1Button").style.display = 'none';
                document.getElementById("backward5Button").style.display = 'none';
                document.getElementById("forward1Button").style.display = 'none';
                document.getElementById("forward5Button").style.display = 'none';
                document.getElementById("selectedFileTitle").style.display = 'none';
            } else {
                document.getElementById("startPosition").style.display = 'initial';
                document.getElementById("finishPosition").style.display = 'initial';
                document.getElementById("wordInput").style.display = 'initial';
                document.getElementById("meaningInput").style.display = 'initial';
                document.getElementById("configContent").style.display = 'inline';
                document.getElementById("configContent_ready").style.display = 'inline';
                document.getElementById("wordList").style.display = 'inline';
                document.getElementById("playButton").style.display = 'inline';
                document.getElementById("convertButton").style.display = 'initial';
                document.getElementById("appendButton").style.display = 'initial';
                document.getElementById("ttsButton").style.display = 'initial';
                document.getElementById("wordList_real").style.display = 'initial';
                document.getElementById("audioPlayer").style.display = 'initial';
                document.getElementById("backward1Button").style.display = 'initial';
                document.getElementById("backward5Button").style.display = 'initial';
                document.getElementById("forward1Button").style.display = 'initial';
                document.getElementById("forward5Button").style.display = 'initial';
                document.getElementById("selectedFileTitle").style.display = 'initial';
            }
        });

        var audioFileSelector = document.getElementById("audioFileSelector");
        audioFileSelector.addEventListener("change", function() {
            this.form.submit();
        });

        var configFileSelector = document.getElementById("configFileSelector");
        var configContent = document.getElementById("configContent");

        configFileSelector.addEventListener("change", function() {
            var selectedConfigFile = this.value;
            if (selectedConfigFile !== "") {
                // Load the config file content
                loadConfigFile(selectedConfigFile);
            } else {
                // Clear the textarea if no config file is selected
                configContent.value = "";
            }
        });

        function loadConfigFile(configFile) {
            // Make an AJAX request to fetch the config file content
            $.ajax({
                url: "configs/" + configFile,
                type: "GET",
                dataType: "text",
                success: function(response) {
                // Update the textarea with the config file content
                configContent.value = response;
                try {
                    var configg = JSON.parse(configContent.value);
                    document.getElementById("configContent_li").value = "会从下面这些词汇抽查或顺序播报";
                    for(var i = 0; i < configg.length; i++){
                        document.getElementById("configContent_li").value = document.getElementById("configContent_li").value + "\n" + (i+1) + ":  " + configg[i].word + "  " + configg[i].meaning;
                    }
                } catch (error) {}
                },
                error: function(xhr, status, error) {
                // Handle any errors
                console.log(error);
                }
            });
        }

        // Trigger the initial loading of config file content if a file is selected
        if (configFileSelector.value !== "") {
            loadConfigFile(configFileSelector.value);
        }

        var shuffleStartButton = document.getElementById("shuffleStartButton");
        var startInOrderButton = document.getElementById("startInOrderButton");

        var fetchedConfigContent;

        shuffleStartButton.addEventListener("click", function(event) {
            event.preventDefault();
            var numWords = parseInt(document.getElementById("numWordsInput").value);
            var repeatTimes = parseInt(document.getElementById("repeatTimesInput").value);
            var pauseTime = parseFloat(document.getElementById("pauseTimeInput").value);
            var configData = JSON.parse(configContent.value);

            document.getElementById("configContent_ready_li").style.display = 'none';

            if (!isNaN(numWords) && !isNaN(repeatTimes) && !isNaN(pauseTime) && configData.length > 0) {
                var randomNumbers = generateRandomNumbers(configData.length, numWords);
                var randomizedConfigData = generateRandomizedConfigData(randomNumbers, repeatTimes, pauseTime, configData);
                var jsonData = JSON.stringify(randomizedConfigData, null, 2);
                var outsider_count = 1;
                configContent_ready.value = jsonData;
                fetchedConfigContent = randomizedConfigData;
                document.getElementById("configContent_ready_li").value = "这次抽查了下面的词汇，要好好对改";
                for(var i = 0; i < fetchedConfigContent.length; i+=repeatTimes){
                    document.getElementById("configContent_ready_li").value = document.getElementById("configContent_ready_li").value + "\n" + (outsider_count) + ":  " + fetchedConfigContent[i].word + "  " + fetchedConfigContent[i].meaning;
                    outsider_count++;
                }
            }
        });

        startInOrderButton.addEventListener("click", function(event) {
            event.preventDefault();
            var numWords = parseInt(document.getElementById("numWordsInput").value);
            var repeatTimes = parseInt(document.getElementById("repeatTimesInput").value);
            var pauseTime = parseFloat(document.getElementById("pauseTimeInput").value);
            var configData = JSON.parse(configContent.value);

            document.getElementById("configContent_ready_li").style.display = 'none';

            if (!isNaN(numWords) && !isNaN(repeatTimes) && !isNaN(pauseTime) && configData.length > 0) {
                var orderedNumbers = generateOrderedNumbers(configData.length, numWords);
                var orderedConfigData = generateRandomizedConfigData(orderedNumbers, repeatTimes, pauseTime, configData);
                var jsonData = JSON.stringify(orderedConfigData, null, 2);
                configContent_ready.value = jsonData;
                fetchedConfigContent = orderedConfigData;
                document.getElementById("configContent_ready_li").value = "这次抽查了下面的词汇，要好好对改";
                for(var i = 0; i < fetchedConfigContent.length; i++){
                    document.getElementById("configContent_ready_li").value = document.getElementById("configContent_ready_li").value + "\n" + (i+1) + ":  " + fetchedConfigContent[i].word + "  " + fetchedConfigContent[i].meaning;
                }
            }
        });


        function generateRandomNumbers(maxValue, numNumbers) {
            var randomNumbers = [];
            for (var i = 0; i < numNumbers; i++) {
                var randomNumber = Math.floor(Math.random() * maxValue);
                if (!randomNumbers.includes(randomNumber)) {
                randomNumbers.push(randomNumber);
                } else {
                i--;
                }
            }
            return randomNumbers;
        }

        function generateOrderedNumbers(maxValue, numNumbers) {
            var orderedNumbers = [];
            for (var i = 0; i < numNumbers; i++) {
                if (i < maxValue) {
                orderedNumbers.push(i);
                } else {
                break;
                }
            }
            return orderedNumbers;
        }

        function generateRandomizedConfigData(numberArray, repeatTimes, pauseTime, configData) {
            var randomizedConfigData = [];
            for (var j = 0; j < numberArray.length; j++) {
                var index = numberArray[j];
                var configItem = configData[index];
                for (var i = 0; i < repeatTimes; i++) {
                    randomizedConfigData.push(configItem);
                }
            }
            return randomizedConfigData.map(function(item) {
                item.pause = pauseTime;
                return item;
            });
        }

        var currentIndex = 0;
        var playbackInterval;

        function playAudio(start, finish, pause) {
            if(!myCheckbox1.checked){
                var audio = document.getElementById("audioPlayer");
                audio.currentTime = start;
                audio.play();
                playbackInterval = setInterval(function() {
                if (audio.currentTime >= finish) {
                    audio.pause();
                    clearInterval(playbackInterval);
                    setTimeout(function() {
                        currentIndex++;
                        if (currentIndex < fetchedConfigContent.length) {
                        playNextItem();
                        }else{
                            var endPlayer = document.getElementById("endPlayer");
                            var ShufflePlayer = document.getElementById("ShufflePlayer");
                            endPlayer.play()
                            document.getElementById("configContent_ready_li").style.display = 'inline';

                            setTimeout(function() {
                                ShufflePlayer.play()
                            }, 5500)

                        }
                    }, pause * 1000);
                }
                }, 10);
            }else{
                playbackInterval = setInterval(function() {
                    clearInterval(playbackInterval);
                    setTimeout(function() {
                        currentIndex++;
                        if (currentIndex < fetchedConfigContent.length) {
                        playNextItem();
                        }else{
                            var endPlayer = document.getElementById("endPlayer");
                            var ShufflePlayer = document.getElementById("ShufflePlayer");
                            endPlayer.play()
                            document.getElementById("configContent_ready_li").style.display = 'inline';

                            setTimeout(function() {
                                ShufflePlayer.play()
                            }, 5500)

                        }
                    }, pause * 1000);
                }, 10);
            }
            

        }

        function playNextItem() {
            var MoondropPlayer = document.getElementById("MoondropPlayer");
            MoondropPlayer.play();

            setTimeout(function() {
                if(!myCheckbox1.checked){
                    var currentItem = fetchedConfigContent[currentIndex];
                    var startInput = document.getElementById("startPosition");
                    var finishInput = document.getElementById("finishPosition");
                    var pauseInput = document.getElementById("pauseTimeInput");

                    console.log(currentItem);
                    
                    startInput.value = currentItem.start;
                    finishInput.value = currentItem.finish;
                    
                    var start = parseFloat(startInput.value);
                    var finish = parseFloat(finishInput.value);
                    var pause = parseFloat(pauseInput.value);
                    
                    playAudio(start, finish, pause);
                }else{
                    var currentItem = fetchedConfigContent[currentIndex];
                    var audioUrl = "http://132.145.27.119:8026/voices/voices/" + encodeURIComponent(currentItem.word) + ".mp3";

                    fetch(audioUrl)
                    .then(response => {
                        if (response.ok) {
                        // Audio source is available
                        var audioElement = new Audio(audioUrl);

                        audioElement.addEventListener('ended', function() {
                            // The audio has finished playing
                            // Proceed to the next action here
                            playAudio(0, 0, document.getElementById("pauseTimeInput").value);
                        });

                        audioElement.addEventListener('error', function() {
                            // Error occurred while loading or playing the audio
                            console.log("Error loading or playing the audio");
                            var argument = currentItem.word;  // Replace with your argument value
                            var xhr = new XMLHttpRequest();
                            xhr.open("GET", "execute_python.php?arg=" + encodeURIComponent(argument), true);
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var response = xhr.responseText;
                                    // Process the response from the Python script
                                    console.log(response);
                                    audioElement.src = audioUrl;
                                    // Start playing the audio
                                    audioElement.play();
                                }else{
                                    console.log("here");
                                    // Set the audio source
                                    audioElement.src = audioUrl;
                                    // Start playing the audio
                                    audioElement.play();
                                }
                            };
                            xhr.send();
                            // Perform actions or error handling here
                        });

                        // Set the audio source
                        audioElement.src = audioUrl;

                        // Start playing the audio
                        audioElement.play();
                        } else {
                        // Audio source is not available (404 error)
                        console.log("Audio source not found");
                        // Refetch the audio
                        var argument = currentItem.word;  // Replace with your argument value
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "execute_python.php?arg=" + encodeURIComponent(argument), true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                var response = xhr.responseText;
                                // Process the response from the Python script
                                console.log(response);
                                audioElement.src = audioUrl;
                                // Start playing the audio
                                audioElement.play();
                            }
                        };
                        xhr.send();
                        // Perform actions or error handling here
                        }
                    })
                    .catch(error => {
                        // Error occurred while fetching the audio source
                        console.error("Error fetching audio source:", error);
                        // Refetch the audio
                        var argument = currentItem.word;  // Replace with your argument value
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "execute_python.php?arg=" + encodeURIComponent(argument), true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                var response = xhr.responseText;
                                // Process the response from the Python script
                                console.log(response);
                                audioElement.src = audioUrl;
                                    // Start playing the audio
                                audioElement.play();
                            }
                        };
                        xhr.send();
                        // Perform actions or error handling here
                    });
                }
            }, 1500); // Delay in milliseconds
        }

        function removeWhitespaceLines(text) {
            // Split the text into lines
            var lines = text.split('\n');

            // Create a regular expression pattern to match lines with only whitespace and alphabetic characters
            var pattern = /^[a-zA-Z\s]*$/;

            // Filter out lines that match the pattern
            var filteredLines = lines.filter(function(line) {
                return !pattern.test(line);
            });

            // Join the filtered lines back into a string
            var filteredText = filteredLines.join('\n');

            return filteredText;
        }

        function shuffleStart() {
            currentIndex = 0;
            clearInterval(playbackInterval);

            // Play the "begin.mp3" file
            var beginPlayer = document.getElementById("beginPlayer");
            beginPlayer.play();
            var ShufflePlayer = document.getElementById("ShufflePlayer");

            setTimeout(function() {
                ShufflePlayer.play();
            }, 18000);

            setTimeout(function() {
                playNextItem();
            }, 20000); // Delay in milliseconds
        }

        function startInOrder() {
            currentIndex = 0;
            clearInterval(playbackInterval);

            // Play the "begin.mp3" file
            var beginPlayer = document.getElementById("beginPlayer");
            beginPlayer.play();
            var ShufflePlayer = document.getElementById("ShufflePlayer");

            setTimeout(function() {
                ShufflePlayer.play();
            }, 18000);

            setTimeout(function() {
                playNextItem();
            }, 20000); // Delay in milliseconds
        }

        document.getElementById("shuffleStartButton").addEventListener("click", shuffleStart);
        document.getElementById("startInOrderButton").addEventListener("click", startInOrder);

        document.getElementById("startPosition").style.display = 'none';
        document.getElementById("finishPosition").style.display = 'none';
        document.getElementById("wordInput").style.display = 'none';
        document.getElementById("wordList").style.display = 'none';
        document.getElementById("meaningInput").style.display = 'none';
        document.getElementById("configContent").style.display = 'none';
        document.getElementById("configContent_ready").style.display = 'none';
        document.getElementById("playButton").style.display = 'none';
        document.getElementById("convertButton").style.display = 'none';
        document.getElementById("appendButton").style.display = 'none';
        document.getElementById("ttsButton").style.display = 'none';
        document.getElementById("wordList_real").style.display = 'none';
        document.getElementById("configContent_ready_li").style.display = 'none';
        document.getElementById("audioPlayer").style.display = 'none';
        document.getElementById("backward1Button").style.display = 'none';
        document.getElementById("backward5Button").style.display = 'none';
        document.getElementById("forward1Button").style.display = 'none';
        document.getElementById("forward5Button").style.display = 'none';
        document.getElementById("selectedFileTitle").style.display = 'none';
        document.getElementById("myCheckbox1").disabled = 'none';
    </script>
</body>
</html>
