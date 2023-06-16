let images = document.querySelectorAll('.images');
let currentImage = 0;

// Toutes les secondes...
setInterval(() => {
    // Version normale
    // currentImage++;

    // if (currentImage >= images.length) {
    //     currentImage = 0;
    // }

    // Version aléatoire
    let previousImage = currentImage;

    do {
        currentImage = Math.floor(Math.random() * images.length);

        if (currentImage === previousImage) {
            console.log('WHILE');
        }
    } while (currentImage === previousImage);

    images.forEach((image) => image.classList.add('opacity-0'));
    images[currentImage].classList.remove('opacity-0');
}, 3000);
