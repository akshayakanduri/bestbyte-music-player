<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="icon" href="./assets/logo.png">
    <title>Spotify - Web Player: Music for everyone</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php
// PHP reads the songs.xml file and parses it
$xmlFile = 'songs.xml';
$songs = [];

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    foreach ($xml->song as $song) {
        $songs[] = [
            'title'       => (string) $song->title,
            'description' => (string) $song->description,
            'image'       => (string) $song->image,
            'audio'       => (string) $song->audio,
        ];
    }
} else {
    echo "<p style='color:red;'>Error: songs.xml not found.</p>";
}
?>

<div class="main">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="nav">
            <div class="nav-option" style="opacity:1;">
                <i class="fa-solid fa-house"></i>
                <a href="#">Home</a>
            </div>
            <div class="nav-option">
                <i class="fa-solid fa-magnifying-glass"></i>
                <a href="#">Search</a>
            </div>
        </div>

        <div class="library">
            <div class="options">
                <div class="lib-option nav-option">
                    <img src="./assets/library_icon.png">
                    <a href="#">Your Library</a>
                </div>
                <div class="icons">
                    <i class="fa-solid fa-plus"></i>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>

            <div class="lib-box">
                <div class="box">
                    <p class="box-p1">Create your first playlist</p>
                    <p class="box-p2">It's easy, we'll help you</p>
                    <button class="badge">Create playlist</button>
                </div>
                <div class="box">
                    <p class="box-p1">Let's find some podcasts to follow</p>
                    <p class="box-p2">We'll keep you updated on new episodes</p>
                    <button class="badge">Browse podcasts</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="sticky-nav">
            <div class="sticky-nav-icons">
                <img src="./assets/backward_icon.png">
                <img src="./assets/forward_icon.png" class="hide">
            </div>
            <div class="sticky-nav-options">
                <button class="badge nav-item">Explore Premium</button>
                <button class="badge nav-item dark-badge">
                    <i class="fa-regular fa-circle-down"></i>
                    Install App
                </button>
                <i class="fa-regular fa-user nav-item"></i>
            </div>
        </div>

        <!-- PHP generates "Recently Played" from the FIRST song -->
        <h2>Recently Played</h2>
        <div class="cards-container">
            <?php if (!empty($songs)): ?>
                <?php $s = $songs[0]; ?>
                <div class="card" data-index="0" data-audio="<?= htmlspecialchars($s['audio']) ?>" data-title="<?= htmlspecialchars($s['title']) ?>" data-desc="<?= htmlspecialchars($s['description']) ?>" data-image="<?= htmlspecialchars($s['image']) ?>">
                    <img src="./<?= htmlspecialchars($s['image']) ?>" class="card-img">
                    <p class="card-title"><?= htmlspecialchars($s['title']) ?></p>
                    <p class="card-info"><?= htmlspecialchars($s['description']) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- PHP generates "Trending now near you" from songs 2 & 3 -->
        <h2>Trending now near you</h2>
        <div class="cards-container">
        <?php for ($i = 1; $i < min(4, count($songs)); $i++): ?>                    
            <?php $s = $songs[$i]; ?>
                <div class="card" data-index="<?= $i ?>" data-audio="<?= htmlspecialchars($s['audio']) ?>" data-title="<?= htmlspecialchars($s['title']) ?>" data-desc="<?= htmlspecialchars($s['description']) ?>" data-image="<?= htmlspecialchars($s['image']) ?>">
                    <img src="./<?= htmlspecialchars($s['image']) ?>" class="card-img">
                    <p class="card-title"><?= htmlspecialchars($s['title']) ?></p>
                    <p class="card-info"><?= htmlspecialchars($s['description']) ?></p>
                </div>
            <?php endfor; ?>
        </div>

        <!-- PHP generates "Featured Charts" from song 4 onwards -->
        <h2>Featured Charts</h2>
        <div class="cards-container">
        <?php for ($i = 3; $i < count($songs); $i++): ?>
            <?php $s = $songs[$i]; ?>
                <div class="card"
                    data-index="<?= $i ?>"
                    data-audio="<?= htmlspecialchars($s['audio']) ?>"
                    data-title="<?= htmlspecialchars($s['title']) ?>"
                    data-desc="<?= htmlspecialchars($s['description']) ?>"
                    data-image="<?= htmlspecialchars($s['image']) ?>">

                    <img src="./<?= htmlspecialchars($s['image']) ?>" class="card-img">
                    <p class="card-title"><?= htmlspecialchars($s['title']) ?></p>
                    <p class="card-info"><?= htmlspecialchars($s['description']) ?></p>
                </div>
            <?php endfor; ?>
        </div>

        <div class="footer">
            <div class="line"></div>
        </div>

    </div>
</div>

<!-- MUSIC PLAYER -->
<div class="music-player">

    <div class="album" id="album-info" style="display:flex; align-items:center;">
        <img id="album-img" src="./assets/logo.png" style="height:56px; width:56px; border-radius:5px; margin-left:1rem;">
    
        <div style="margin-left:10px;">
            <p id="album-title" style="margin:0; font-size:0.9rem;">No song</p>
            <p id="album-desc" style="margin:0; font-size:0.75rem; opacity:0.7;">Select a song</p>
        </div>
    </div>

    <div class="player">
        <div class="player-controls">
            <img src="./assets/player_icon1.png" class="player-control-icon" id="shuffle-btn">
            <img src="./assets/player_icon2.png" class="player-control-icon" id="prev-btn">
            <img src="./assets/player_icon3.png" class="player-control-icon" id="play-btn" style="opacity:1; height:2rem;">
            <img src="./assets/player_icon4.png" class="player-control-icon" id="next-btn">
            <img src="./assets/player_icon5.png" class="player-control-icon" id="repeat-btn">
        </div>

        <div class="playback-bar">
            <span class="curr-time">00:00</span>
            <input type="range" min="0" max="100" value="0" class="progress-bar" id="progress-bar">
            <span class="tot-time">0:00</span>
        </div>
    </div>

    <div class="controls"></div>
</div>


<?php print_r($songs); ?>

<!-- JS: controls the audio player -->
<script>
document.addEventListener("DOMContentLoaded", function () {

const songs = <?php echo json_encode($songs); ?>;

let currentIndex = 0;
let isPlaying = false;
const audio = new Audio();

const playBtn = document.getElementById('play-btn');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

const albumImg = document.getElementById('album-img');
const albumTitle = document.getElementById('album-title');
const albumDesc = document.getElementById('album-desc');

const cards = document.querySelectorAll('.card');

function loadSong(index) {
    const song = songs[index];

    audio.src = "./" + song.audio;
    audio.load();

    albumImg.src = "./" + song.image;
    albumTitle.textContent = song.title;
    albumDesc.textContent = song.description;

    highlightCard(index);
}

function highlightCard(index) {
    cards.forEach((card, i) => {
        card.style.border = i === index ? "2px solid #1db760" : "none";
    });
}

function togglePlay() {
    if (isPlaying) {
        audio.pause();
        isPlaying = false;
    } else {
        audio.play();
        isPlaying = true;
    }
}

cards.forEach((card) => {
    const index = parseInt(card.getAttribute("data-index"));

    card.style.cursor = "pointer";

    card.addEventListener('click', () => {
        console.log("Clicked:", index, songs[index]);
        currentIndex = index;
        loadSong(index);
        audio.play();
        isPlaying = true;
    });
});

playBtn.addEventListener('click', togglePlay);

nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % songs.length;
    loadSong(currentIndex);
    audio.play();
    isPlaying = true;
});

prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + songs.length) % songs.length;
    loadSong(currentIndex);
    audio.play();
    isPlaying = true;
});

audio.addEventListener('ended', () => {
    currentIndex = (currentIndex + 1) % songs.length;
    loadSong(currentIndex);
    audio.play();
});

loadSong(currentIndex);

});
</script>

</body>
</html>