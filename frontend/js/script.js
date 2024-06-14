//Defining the elements for the music player
let musicPlayerTitle = document.querySelector('.music-player-song-detail h3');
let musicPlayerArtist = document.querySelector('.music-player-song-detail p');
let musicPlayerImg = document.querySelector('.music-player-song-photo img')
let songRows = document.querySelectorAll('table tbody tr');
let music = document.getElementById('audio');
let playBtn = document.querySelector('#play');
let previousBtn = document.querySelector("#previous");
let nextBtn = document.querySelector("#next");
let repeatBtn = document.getElementById("repeat");
let shuffleBtn = document.getElementById('shuffle');
let progress = document.querySelector(".progress");
let playTime = document.getElementById("currentTime");
let totalTime = document.getElementById("totalTime");
let volumeSlider = document.getElementById("volume-slider");
let volumeIcon = document.getElementById("volume-icon");
let progress_div = document.getElementById("progress-div");
let downloadBtn = document.getElementById('music-player-download-btn');

//to store the songs and the index of the current song
let songsCollection = [];
let songIndex = 0;

//declaring that the music is empty at first
let isPlaying = false;

//function to show what the music player is playing
const loadSongs = (songs) => {
    musicPlayerTitle.innerText = songs.name;
    musicPlayerArtist.innerText = songs.artist;
    downloadBtn.href = `assets/songs/${songs.name}.mp3`;
    music.src = `assets/songs/${songs.name}.mp3`;
    musicPlayerImg.src = `assets/artists/${songs.image}`;
    musicPlayerImg.style.display='block';
}

//function to check download
downloadBtn.addEventListener('click', function(event) {
    // Check if the href attribute is empty
    if (this.getAttribute('href') === '') {
        // Alert the user to select a song
        alert('Please select a song to download.');
        event.preventDefault();
    }
});

//function to check if audio is empty or not
const checkAudio = () => {
    if (!music.src || music.src === 'null') {
        alert('Please Select a Song');
        return false;
    } else {
        return true;
    }
}

//for playing the music
const playMusic = () => {
    if (checkAudio()) {
        isPlaying = true;
        play.classList.replace("fa-play", "fa-pause");
        music.play();
    }
};

//for pausing the music
const pauseMusic = () => {
    isPlaying = false;
    music.pause();
    play.classList.replace("fa-pause", "fa-play");
};

//for the play and pause button
playBtn.addEventListener('click', () => {
    if (isPlaying == false) {
        playMusic();
    }
    else {
        pauseMusic();
    }
});

//for playing the next song
const nextSong = () => {
    if (isShuffling == true) {
        songIndex = (songIndex + 1) % shuffledSongs.length;
        loadSongs(shuffledSongs[songIndex]);
        playMusic();
    }
    else {
        songIndex = (songIndex + 1) % songsCollection.length;
        loadSongs(songsCollection[songIndex]);
        playMusic();
    }
}

//for playing the previous song
const previousSong = () => {
    if (isShuffling == true) {
        songIndex = (songIndex - 1 + shuffledSongs.length) % shuffledSongs.length;
        loadSongs(shuffledSongs[songIndex]);
        playMusic();
    }
    else {
        songIndex = (songIndex - 1 + songsCollection.length) % songsCollection.length;
        loadSongs(songsCollection[songIndex]);
        playMusic();
    }
}

//calling the above functions according to their buttons
nextBtn.addEventListener('click', nextSong);
previousBtn.addEventListener('click', previousSong);

// For looping the song
let isLooping = false;
const loopOn = () => {
    if (checkAudio()) {
        isLooping = true;
        repeatBtn.style.color = `#1572e3`;
        // shuffleOff();
    }
};

const loopSong = () => {
    music.currentTime = 0;
    music.play();
}

const loopOff = () => {
    isLooping = false;
    repeat.style.color = `white`;
};

//for shuffling the song
let isShuffling = false;
let shuffledSongs;
const shuffleSongs = (array) => {
    let shuffledArray = [];
    let usedIndexes = [];
    let i = 0;
    while (i < array.length) {
        let randomNumber = Math.floor(Math.random() * array.length);
        if (!usedIndexes.includes(randomNumber)) {
            shuffledArray.push(array[randomNumber]);
            usedIndexes.push(randomNumber);
            i++;
        }
    }
    return shuffledArray;
}

const shuffleOn = () => {
    if (checkAudio()) {
        isShuffling = true;
        shuffleBtn.style.color = `#1572e3`;
        shuffledSongs = shuffleSongs(songsCopy);
        //to update the songIndex
        let songName = musicPlayerTitle.innerText;
        let songArtist = musicPlayerArtist.innerText;
        songIndex = shuffledSongs.findIndex(song => song.name === songName && song.artist === songArtist);
    }

};

const shuffleOff = () => {
    isShuffling = false;
    //to update the songIndex
    let songName = musicPlayerTitle.innerText;
    let songArtist = musicPlayerArtist.innerText;
    songIndex = songsCollection.findIndex(song => song.name === songName && song.artist === songArtist);
    shuffleBtn.style.color = `white`;
};

shuffleBtn.addEventListener('click', () => {
    if (isShuffling == false) {
        shuffleOn();
    }
    else {
        shuffleOff();
    }
})

//calling the loop functions when the repeatBtn is pressed
repeatBtn.addEventListener('click', () => {
    if (isLooping == false) {
        loopOn();
    }
    else {
        loopOff();
    }
})

// calling next song
music.addEventListener('ended', () => {
    if (isLooping == true) {
        loopSong();
    }
    else {
        nextSong();
    }
});

//to make the song list to play through the currentPlaylist
let songsCopy;
const makeSongList = (songRow) => {
    let temp = []; // to store the songs temporarily
    let currPlaylist = songRow.parentNode.querySelectorAll('tr');
    currPlaylist.forEach((row, index) => {
        let cells = row.querySelectorAll('td');
        let name = cells[1].textContent.trim();
        let artist = cells[2].textContent.trim();
        let genre = cells[3].textContent.trim();
        let album = cells[4].textContent.trim();
        let imageSrc = cells[5].querySelector('img').src;  
        let imageName = imageSrc.split('/').pop();;
        let songObject = { name: name, artist: artist, genre: genre, album: album, image: imageName };
        temp.push(songObject);
    });
    //updating the value of temp
    songsCollection = temp;
    songsCopy = songsCollection.slice();
}

//calling the above two functions when the songRow is clicked
const songFunction = (e) => {
    // Accessing the clicked row
    let songRow = e.currentTarget || e;
    // Since the name and artist are in the first and third column respectively
    let songName = songRow.querySelectorAll('td')[1].textContent;
    let songArtist = songRow.querySelectorAll('td')[2].textContent;
    // Call your existing logic or functions
    makeSongList(songRow);
    if (isShuffling) {
        shuffleOff();
    }
    // Find the index of the clicked song in the songsCollection
    songIndex = songsCollection.findIndex(song => song.name === songName && song.artist === songArtist);
    // Load and play the clicked song
    loadSongs(songsCollection[songIndex]);
    playMusic();
};

songRows.forEach((songRow) => {
    songRow.addEventListener('click', songFunction);
});

//for progress bar and time of the music
music.addEventListener('timeupdate', (event) => {
    const { currentTime, duration } = event.srcElement;
    let widthOfSong = (currentTime / duration) * 100;
    progress.style.width = `${widthOfSong}%`;
    //music time and duration
    let minutes = Math.floor(duration / 60);
    let seconds = Math.floor(duration % 60);
    if (duration) {
        totalTime.innerHTML = `${minutes}:${seconds}`;
    }
    // for current time
    let currentMinutes = Math.floor(currentTime / 60);
    let currentSeconds = Math.floor(currentTime % 60);
    if (currentSeconds < 10) {
        currentSeconds = `0${currentSeconds}`;
    }
    playTime.innerHTML = `${currentMinutes}:${currentSeconds}`;
});

//to go to a specific part of the music
progress_div.addEventListener('click', (event) => {
    const { duration } = music;
    let moveProgress = (event.offsetX / event.srcElement.clientWidth) * duration;
    music.currentTime = moveProgress;

})

//for volume slider
music.volume = volumeSlider.value / 100;
volumeSlider.addEventListener('input', () => {
    music.volume = volumeSlider.value / 100;
    if (volumeSlider.value >= 70) {
        volumeIcon.classList.replace("fa-volume-low", "fa-volume-high");
        volumeIcon.classList.remove("fa-volume-mute");
    } else if (volumeSlider.value > 0) {
        volumeIcon.classList.replace("fa-volume-high", "fa-volume-low");
        volumeIcon.classList.remove("fa-volume-mute");
    } else {
        volumeIcon.classList.add("fa-volume-mute");  // Add the mute class
    }
})