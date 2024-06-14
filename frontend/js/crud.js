//for auto search bar
let mainSearchBar = document.getElementById("main-search-bar");
mainSearchBar.addEventListener('keyup', function () {
    //get searched keyword 
    let searchValue = this.value;
    let url = 'phpFiles/search.php?search=' + searchValue;
    fetch(url)
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            let searchContent = document.getElementById('search-content');
            if (data.includes('No Songs Found')) {
                searchContent.querySelector('#error-msg').style.display = 'block';
                searchContent.querySelector('table tbody').innerHTML = '';
            }else{
                searchContent.querySelector('#error-msg').style.display = 'none';
                searchContent.querySelector('table tbody').innerHTML = data;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
});

//to display all the songs
function displaySongs() {
    fetch('phpFiles/allSongs.php')
        .then(response => response.text())
        .then(data => {
            document.querySelector('#home-content table tbody').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

//calling the function when the page is loaded
displaySongs();
document.getElementById('home-section').addEventListener('click', () => {
    displaySongs();
})

//to display the songs from the artist and genres
boxContents.forEach(box => {
    box.addEventListener('click', () => {
        //get text from div
        let content = box.innerText;
        // Create a FormData object to send data to PHP
        var formData = new FormData();
        formData.append('textData', content);
        fetch('phpFiles/displaySpecific.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                if (data.includes('No_Songs_Found')) {
                    document.getElementById('home-content').querySelector('#error-msg').style.display = 'block';
                    document.getElementById('home-content').querySelector('table tbody').innerHTML = '';
                }else{
                    document.getElementById('home-content').querySelector('#error-msg').style.display = 'none';
                    document.getElementById('home-content').querySelector('table tbody').innerHTML = data;
                }   
            })
            .catch(function (error) {
                console.log(error);
            });
    })
})



//function to display liked songs
const likedSongsDisplay = () => {
    fetch('phpFiles/likeSongs.php')
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            let likeContent = document.querySelector('#liked-content');
            if (data.includes("You haven't liked any songs yet")) {
                likeContent.querySelector('#error-msg').style.display = 'block';
                likeContent.querySelector('table tbody').innerHTML = '';
            }else{
                likeContent.querySelector('#error-msg').style.display = 'none';
                likeContent.querySelector('table tbody').innerHTML = data;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

//defining when the above function should be called
document.getElementById('liked-section').addEventListener('click', () => {
    likedSongsDisplay();
})

//function to perform like dislike feature
function likeDislikeFn(event) {
    event.stopPropagation();
    let likeDislikeTd = event.currentTarget;

    let songId = likeDislikeTd.querySelector('span').innerText;
    let icon = likeDislikeTd.querySelector('i');
    // Create a FormData object to send data to PHP
    var formData = new FormData();
    formData.append('songId', songId);
    fetch('phpFiles/likeDislike.php', {
        method: 'POST',
        body: formData
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            //change the color of the icon
            if (icon.style.color === 'white') {
                icon.style.color = '#284edb';
            } else {
                icon.style.color = 'white';
            }
            likedSongsDisplay();
        })
        .catch(function (error) {
            console.log(error);
        });
}

document.querySelectorAll('.likeDislike').forEach(elem => {
    elem.addEventListener('click', likeDislikeFn); //calling the above function on click
});
//to display playlist
const displayPlaylist = () => {
    fetch('phpFiles/displayPlaylist.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('playlistCollection').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

//calling the above function when site is opened
displayPlaylist();
//to make a playlist
document.getElementById('playlistFormBtn').addEventListener('click', function (event) {
    event.preventDefault();
    // Get form data
    var formData = new FormData(document.getElementById('playlistForm'));
    // Send form data using Fetch method
    fetch('phpFiles/createPlaylist.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            displayPlaylist();
            if (data.includes("Playlist Successfully Created")) {
                document.querySelector('.popup').classList.toggle('active');
                alert('Playlist Successfully Created');
            }
        })
        .catch(error => console.error('Error:', error));
});

//function to display playlist options
const displayPlaylistOptions = () => {
    fetch('phpFiles/playlistOptions.php')
        .then(response => response.text())
        .then(data => {
            document.querySelector('#addToPlaylist-form form select').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

//functions to add songs to playlist
const songIdToPlaylist = (event) => {
    event.stopPropagation();
    let td = event.currentTarget;
    let songId = td.querySelector('span').innerText;
    //setting the input value to the corresponding song id
    document.querySelector('#addToPlaylist-form form input').value = songId;
}

//when the button is clicked the song is added to the playlist
document.getElementById('addToPlaylistFormBtn').addEventListener('click', function (event) {
    event.preventDefault();
    // console.log('fasfasfsa');
    // Get form data
    var formData = new FormData(document.getElementById('addToPlaylistForm'));
    // Send form data using Fetch method
    fetch('phpFiles/addToPlaylist.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Success")) {
                document.querySelector('.popup').classList.toggle('active');
                alert('Added to Playlist');
            } else {
                alert('Song is already in the playlist');
            }
        })
        .catch(error => console.error('Error:', error));
});

//to display playlist songs
let playlistData;
const displayPlaylistSongs = (playlistData) => {
    fetch('phpFiles/playlistSongs.php', {
        method: 'POST',
        body: playlistData
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            let playlistContent = document.querySelector('#playlist-content');
            if (data.includes("You haven't added any songs to your playlist yet")) {
                playlistContent.querySelector('#error-msg').style.display = 'block';
                playlistContent.querySelector('table tbody').innerHTML = '';
            }else{
                playlistContent.querySelector('#error-msg').style.display = 'none';
                playlistContent.querySelector('table tbody').innerHTML = data;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

const showPlaylistSongs = (event) => {
    let playlistID = event.target.id;
    playlistData = new FormData();
    playlistData.append('playlistID', playlistID);
    displayPlaylistSongs(playlistData);
}

//to delete playlist
function deletePlaylist(event) {
    event.stopPropagation();
    var confirm = window.confirm('Are you sure you want to delete?')
    if (confirm) {
        let playlistID = event.target.id;
        var formData = new FormData();
        formData.append('playlistID', playlistID);
        fetch('phpFiles/deletePlaylist.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                openDiv(document.getElementById('home-section'));
                displayPlaylist();
            })
            .catch(function (error) {
                console.log(error);
            });
    }
}

//to delete playlist song
function deletePlaylistSong(event) {
    event.stopPropagation();
    let songId = event.target.id;
    var formData = new FormData();
    formData.append('Song_ID', songId);
    fetch('phpFiles/deletePlaylistSong.php', {
        method: 'POST',
        body: formData
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            displayPlaylistSongs(playlistData);
        })
        .catch(function (error) {
            console.log(error);
        });
}

//to edit profile
document.getElementById('profileEditForm').addEventListener('submit',(event)=>{
    event.preventDefault();
    let formData = new FormData(document.getElementById('profileEditForm'));
    fetch('phpFiles/editProfile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
    if (data.status === 'success') {
        // Reload the page after successful edit
        alert('Profile Updated')
        window.location.reload();
    } else {
        // Handle error scenario if needed
        alert('Edit operation failed.');
    }
    })
})

//to edit artist profile
if (document.getElementById('editArtistProfile')) {
    document.getElementById('editArtistProfile').addEventListener('submit',(event)=>{
        event.preventDefault();
        let formData = new FormData(document.getElementById('editArtistProfile'));
        fetch('phpFiles/editArtistProfile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
        if (data.status === 'success') {
            // Reload the page after successful edit
            alert('Profile Updated')
            window.location.reload();
        } else {
            // Handle error scenario if needed
            alert('Edit operation failed.');
        }
        })
    })
}

//to buy premium
if (document.getElementById('premiumBtn')) {
    document.getElementById('premiumBtn').addEventListener('click',(event)=>{
        fetch('phpFiles/buyPremium.php')
        .then(response => response.json())
        .then(data => {
        if (data.status === 'success') {
            alert('Premium Bought')
            window.location.reload();
        } else {
            // Handle error scenario if needed
            alert('Error Occured');
        }
        })
    })
}

//to create an album
function createAlbum() {
    let formData = new FormData(albumForm);
    fetch('phpFiles/createAlbum.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('success')) {
            alert('album created');
            getAlbums();
        }else{
            console.log('error making album');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

//to get albums
const getAlbums = () => {
    fetch('phpFiles/userAlbums.php')
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            document.getElementById('albumOptions').innerHTML = data;
        })
        .catch(function (error) {
            console.log(error);
        });
}

let albumForm = null; // Initialize albumForm to null

// Check if the element with ID 'createAlbumForm' exists
if (document.getElementById('createAlbumForm')) {
    albumForm = document.getElementById('createAlbumForm'); // Assign the element to albumForm
    albumForm.addEventListener('submit', (event)=> {
        event.preventDefault();
        createAlbum();
        getAlbums()
    });
}

//to display your songs
const displayYourSongs = () => {
    fetch('phpFiles/yourSongs.php')
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            let yourSongsContent = document.getElementById('your_songs-content');
            if (data.includes("No Songs Found")) {
                yourSongsContent.querySelector('#error-msg').style.display = 'block';
                yourSongsContent.querySelector('table tbody').innerHTML = '';
            }else{
                yourSongsContent.querySelector('#error-msg').style.display = 'none';
                yourSongsContent.querySelector('table tbody').innerHTML = data;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

document.getElementById('your_songs-section').addEventListener('click',()=>{
    displayYourSongs();
})


//to upload song
function registerArtist() {
    let formData = new FormData(registerArtistForm);
    fetch('phpFiles/registerArtist.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Registered as artist');
            window.location.reload();
        } else {
            console.log('Error Uploading Song');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

let registerArtistForm = null;
if (document.getElementById('registerArtistForm')) {
    registerArtistForm=document.getElementById('registerArtistForm');
    registerArtistForm.addEventListener('submit',(event)=>{
        event.preventDefault();
        registerArtist();
    })
}


//to upload song
function uploadSong() {
    let formData = new FormData(uploadSongForm);
    fetch('phpFiles/uploadSong.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Song Uploaded');
            displaySongs();
            displayYourSongs();
        } else {
            console.log('Error Uploading Song');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

let uploadSongForm = null;
if (document.getElementById('uploadSongForm')) {
    uploadSongForm = document.getElementById('uploadSongForm');
    uploadSongForm.addEventListener('submit',(event)=>{
        event.preventDefault();
        uploadSong();
    })
} 

//function to delete own song
function deleteYourSong(event) {
    event.stopPropagation();
    var confirm = window.confirm('Are you sure you want to delete?')
    if (confirm) {
    let songId = event.target.id;
    var formData = new FormData();
    formData.append('Song_ID', songId);
    fetch('phpFiles/deleteYourSong.php', {
        method: 'POST',
        body: formData
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            displayYourSongs();
        })
        .catch(function (error) {
            console.log(error);
        });
    }
}



