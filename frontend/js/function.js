let welcomeMsg = document.querySelector('.top-right-bar h2');
let navIcons = document.querySelectorAll('.nav-section-members');
let searchBar = document.getElementById('search-bar');
let boxContents = document.querySelectorAll('.box-content');
let artistBoxContents = document.querySelectorAll('.artist-box .box-content');

// Function to update the welcome msg
const updateWelcomeMsg = () => {
    let date = new Date();
    if (date.getHours() > 3 && date.getHours() < 12) {
        welcomeMsg.innerText = 'Good Morning';
    } else if (date.getHours() > 10 && date.getHours() < 17) {
        welcomeMsg.innerText = 'Good Afternoon';
    } else {
        welcomeMsg.innerText = 'Good Evening';
    }
}
updateWelcomeMsg();

// Loop through each artist box
boxContents.forEach(box => {
    // Find the image within the artist box
    const image = box.querySelector('img');
    // Create a canvas element
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    // Set the canvas size to match the image dimensions
    canvas.width = image.width;
    canvas.height = image.height;
    // Draw the image onto the canvas
    context.drawImage(image, 0, 0, image.width, image.height);
    // Get the image data from the canvas
    const imageData = context.getImageData(0, 0, canvas.width, canvas.height).data;
    // Calculate the average RGB values
    let r = 0, g = 0, b = 0;
    for (let i = 0; i < imageData.length; i += 4) {
        r += imageData[i];
        g += imageData[i + 1];
        b += imageData[i + 2];
    }
    r = Math.floor(r / (imageData.length / 4));
    g = Math.floor(g / (imageData.length / 4));
    b = Math.floor(b / (imageData.length / 4));
    // Set the background color of the artist box
    box.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
});

//Function to open the div when the sidebar buttons are clicked
function openDiv (navIcon){
    let divs = document.querySelectorAll('.content-part');
    divs.forEach((div) => {
        div.style.display = 'none';
    })
    let divName = navIcon.title;
    //for the search bar display
    if (divName == 'search-content') {
        searchBar.style.display = 'flex';
        // clear the content of the search page 
        searchBar.querySelector('input').value='';
        document.querySelector('#search-content table tbody').innerHTML = '';
    } else {
        searchBar.style.display = 'none';
    }
    //for playlist name
    if (divName == 'playlist-content') {
        let playlistHeading= document.getElementById(divName).querySelector('h1');
        let playlistName = navIcon.querySelector('div').innerText;
        // changing the name of the playlist
        playlistHeading.innerText = playlistName;
    }
    let contentFile = document.getElementById(divName);
    contentFile.style.display = 'block';
}

//to open the relevant contents when the sidebar button is pressed
navIcons.forEach((navIcon) => {
    navIcon.addEventListener('click', () => openDiv(navIcon))
})



